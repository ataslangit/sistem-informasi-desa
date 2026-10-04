<?php

declare(strict_types=1);

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\Resident;
use App\Services\LetterPdfService;
use App\Services\LetterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CitizenLetterController extends Controller
{
    public function __construct(
        protected LetterService $letterService,
        protected LetterPdfService $letterPdfService
    ) {}

    /**
     * Menampilkan daftar permohonan surat milik warga yang sedang login.
     */
    public function index(Request $request): View
    {
        $requests = LetterRequest::with(['template', 'resident'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('citizen.letters.index', compact('requests'));
    }

    /**
     * Form pengajuan surat layanan mandiri.
     */
    public function create(Request $request): View
    {
        $templates = LetterTemplate::where('is_active', true)->orderBy('name')->get();

        // Cari resident yang terhubung dengan akun warga
        $resident = Resident::where('user_id', $request->user()->id)->first();

        // Jika belum terhubung via user_id, cari via NIK dari metadata akun
        if (! $resident && isset($request->user()->metadata['nik'])) {
            $resident = Resident::where('nik', $request->user()->metadata['nik'])->first();
        }

        return view('citizen.letters.create', compact('templates', 'resident'));
    }

    /**
     * Simpan pengajuan surat dari warga.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Cari resident milik user
        $resident = Resident::where('user_id', $user->id)->first();
        if (! $resident && isset($user->metadata['nik'])) {
            $resident = Resident::where('nik', $user->metadata['nik'])->first();
        }

        if (! $resident) {
            return back()->with('error', 'Profil kependudukan belum terhubung dengan akun Anda. Silakan hubungi aparat desa.');
        }

        $validated = $request->validate([
            'letter_template_id' => ['required', 'exists:letter_templates,id'],
            'purpose' => ['required', 'string', 'min:5', 'max:500'],
            'extra_data' => ['nullable', 'array'],
        ]);

        $template = LetterTemplate::findOrFail($validated['letter_template_id']);
        $extraData = $validated['extra_data'] ?? [];

        $letterRequest = $this->letterService->createRequest(
            user: $user,
            resident: $resident,
            template: $template,
            purpose: $validated['purpose'],
            extraData: $extraData
        );

        return redirect()->route('citizen.letters.show', $letterRequest)
            ->with('success', 'Permohonan surat berhasil dikirim! Silakan pantau tahapan verifikasi secara berkala.');
    }

    /**
     * Halaman tracking status permohonan surat warga.
     */
    public function show(LetterRequest $letterRequest): View
    {
        // Pastikan hanya pemilik yang bisa melihat
        if ($letterRequest->user_id !== auth()->id() && ! auth()->user()->can('letters.process')) {
            abort(403, 'Anda tidak berhak melihat permohonan ini.');
        }

        $letterRequest->load([
            'template',
            'resident.family',
            'rtVerifier',
            'staffVerifier',
            'kadesApprover',
            'rejecter',
        ]);

        return view('citizen.letters.show', compact('letterRequest'));
    }

    /**
     * Download dokumen PDF surat yang sudah disahkan.
     */
    public function downloadPdf(LetterRequest $letterRequest): Response
    {
        if ($letterRequest->user_id !== auth()->id() && ! auth()->user()->can('letters.process')) {
            abort(403, 'Akses ditolak.');
        }

        if (! $letterRequest->isApproved()) {
            return back()->with('error', 'Surat belum disahkan oleh Kepala Desa.');
        }

        $pdf = $this->letterPdfService->generatePdf($letterRequest);
        $filename = sprintf('Surat_%s_%s.pdf', $letterRequest->template->code, $letterRequest->resident->nik);

        return $pdf->stream($filename);
    }
}
