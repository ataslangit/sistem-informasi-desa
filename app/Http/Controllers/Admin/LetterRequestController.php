<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Services\LetterPdfService;
use App\Services\LetterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LetterRequestController extends Controller
{
    public function __construct(
        protected LetterService $letterService,
        protected LetterPdfService $letterPdfService
    ) {}

    /**
     * Menampilkan daftar permohonan surat masuk.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status');
        $templateId = $request->input('template_id');
        $keyword = $request->input('keyword');

        $query = LetterRequest::with(['template', 'resident.family', 'user'])
            ->orderByDesc('id');

        if ($status) {
            $query->where('status', $status);
        }

        if ($templateId) {
            $query->where('letter_template_id', $templateId);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('request_number', 'like', "%{$keyword}%")
                    ->orWhere('letter_number', 'like', "%{$keyword}%")
                    ->orWhereHas('resident', function ($resQuery) use ($keyword) {
                        $resQuery->where('name', 'like', "%{$keyword}%")
                            ->orWhere('nik', 'like', "%{$keyword}%");
                    });
            });
        }

        $requests = $query->paginate(15)->withQueryString();
        $templates = LetterTemplate::where('is_active', true)->orderBy('name')->get();

        // Hitung counter status untuk tab/badge
        $counts = [
            'pending_rt' => LetterRequest::where('status', LetterRequest::STATUS_PENDING_RT)->count(),
            'pending_staff' => LetterRequest::where('status', LetterRequest::STATUS_PENDING_STAFF)->count(),
            'pending_kades' => LetterRequest::where('status', LetterRequest::STATUS_PENDING_KADES)->count(),
            'approved' => LetterRequest::where('status', LetterRequest::STATUS_APPROVED)->count(),
            'rejected' => LetterRequest::where('status', LetterRequest::STATUS_REJECTED)->count(),
        ];

        return view('admin.letter_requests.index', compact(
            'requests',
            'templates',
            'status',
            'templateId',
            'keyword',
            'counts'
        ));
    }

    /**
     * Menampilkan detail permohonan surat dan timeline persetujuan.
     */
    public function show(LetterRequest $letterRequest): View
    {
        $letterRequest->load([
            'template',
            'resident.family',
            'user',
            'rtVerifier',
            'staffVerifier',
            'kadesApprover',
            'rejecter',
        ]);

        $previewContent = $this->letterService->parseTemplateContent($letterRequest);
        $suggestedLetterNumber = $letterRequest->letter_number ?: $this->letterService->generateOfficialLetterNumber($letterRequest);

        return view('admin.letter_requests.show', compact('letterRequest', 'previewContent', 'suggestedLetterNumber'));
    }

    /**
     * Tahap 1: Verifikasi Ketua RT/RW.
     */
    public function verifyRt(Request $request, LetterRequest $letterRequest): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasRole(['superadmin', 'rt', 'perangkat']) && ! $user->hasPermission('letters.verify_rt') && ! $user->hasPermission('letters.process')) {
            abort(403, 'Anda tidak memiliki hak otorisasi untuk memverifikasi tahap RT/RW.');
        }

        $request->validate([
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->letterService->verifyByRt(
            $letterRequest,
            $user,
            $request->input('notes')
        );

        return redirect()->route('admin.letter-requests.show', $letterRequest)
            ->with('success', 'Permohonan surat berhasil diverifikasi pada tingkat RT/RW.');
    }

    /**
     * Bypass verifikasi RT/RW oleh Staf / Administrator Desa (berkas fisik RT/RW).
     */
    public function bypassRt(Request $request, LetterRequest $letterRequest): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasRole(['superadmin', 'perangkat']) && ! $user->hasPermission('letters.process')) {
            abort(403, 'Hanya Staf / Perangkat Desa yang berwenang melakukan bypass verifikasi RT/RW.');
        }

        $request->validate([
            'bypass_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->letterService->bypassRtAndVerify(
            $letterRequest,
            $user,
            $request->input('bypass_notes')
        );

        return redirect()->route('admin.letter-requests.show', $letterRequest)
            ->with('success', 'Verifikasi RT/RW berhasil di-bypass oleh staf dan berkas diteruskan ke Kepala Desa.');
    }

    /**
     * Tahap 2: Verifikasi Staf Desa.
     */
    public function verifyStaff(Request $request, LetterRequest $letterRequest): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasRole(['superadmin', 'perangkat']) && ! $user->hasPermission('letters.process')) {
            abort(403, 'Anda tidak memiliki hak otorisasi untuk memverifikasi tahap Staf Desa.');
        }

        $request->validate([
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->letterService->verifyByStaff(
            $letterRequest,
            $user,
            $request->input('notes')
        );

        return redirect()->route('admin.letter-requests.show', $letterRequest)
            ->with('success', 'Permohonan surat berhasil diverifikasi oleh Staf Desa dan diteruskan ke Kepala Desa.');
    }

    /**
     * Tahap 3: Persetujuan & Tanda Tangan Elektronik (TTE) Kepala Desa.
     */
    public function approveKades(Request $request, LetterRequest $letterRequest): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasRole(['superadmin', 'kades']) && ! $user->hasPermission('letters.approve')) {
            abort(403, 'Hanya Kepala Desa yang berwenang memberikan pengesahan dan TTE.');
        }

        $request->validate([
            'letter_number' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->letterService->approveByKades(
            $letterRequest,
            $user,
            $request->input('notes'),
            $request->input('letter_number')
        );

        return redirect()->route('admin.letter-requests.show', $letterRequest)
            ->with('success', 'Surat berhasil disahkan dan ditandatangani secara elektronik (TTE) oleh Kepala Desa.');
    }

    /**
     * Menolak permohonan surat.
     */
    public function reject(Request $request, LetterRequest $letterRequest): RedirectResponse
    {
        if (! $letterRequest->canBeProcessedBy($request->user())) {
            abort(403, 'Anda tidak memiliki hak otorisasi untuk menolak permohonan surat pada tahapan ini.');
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $this->letterService->reject(
            $letterRequest,
            $request->user(),
            $request->input('rejection_reason')
        );

        return redirect()->route('admin.letter-requests.show', $letterRequest)
            ->with('success', 'Permohonan surat telah ditolak.');
    }

    /**
     * Download dokumen PDF resmi.
     */
    public function downloadPdf(LetterRequest $letterRequest): Response
    {
        $pdf = $this->letterPdfService->generatePdf($letterRequest);
        $filename = sprintf('Surat_%s_%s.pdf', $letterRequest->template->code, $letterRequest->resident->nik);

        return $pdf->stream($filename);
    }
}
