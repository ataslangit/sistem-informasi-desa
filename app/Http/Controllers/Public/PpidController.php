<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InformationObjection;
use App\Models\InformationRequest;
use App\Models\PublicDocument;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PpidController extends Controller
{
    /**
     * Halaman Utama PPID Desa: Profil, Struktur, dan Maklumat Pelayanan Informasi.
     */
    public function index(): View
    {
        $ppidProfile = [
            'village_name' => Setting::get('village_name', 'Sukamaju'),
            'kades_name' => Setting::get('ppid_leader_name', 'Kepala Desa Sukamaju'),
            'sekdes_name' => Setting::get('ppid_officer_name', 'Sekretaris Desa Sukamaju'),
            'address' => Setting::get('village_address', 'Jl. Raya Desa No. 01'),
            'phone' => Setting::get('village_phone', '021-87654321'),
            'email' => Setting::get('village_email', 'ppid@sidesa.id'),
            'maklumat' => Setting::get('ppid_maklumat', 'Pemerintah Desa berkomitmen memberikan pelayanan informasi publik secara cepat, tepat waktu, biaya ringan, dan proporsional sesuai ketentuan peraturan perundang-undangan.'),
        ];

        $latestDocuments = PublicDocument::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        $stats = [
            'total_documents' => PublicDocument::published()->count(),
            'total_requests' => InformationRequest::count(),
            'resolved_requests' => InformationRequest::whereIn('status', ['approved', 'rejected'])->count(),
        ];

        return theme_view('ppid.index', compact('ppidProfile', 'latestDocuments', 'stats'));
    }

    /**
     * Repositori Dokumen Publik Desa (Daftar Informasi Publik - DIP).
     */
    public function documents(Request $request): View
    {
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $documentType = $request->input('document_type');
        $year = $request->filled('year') ? (int) $request->input('year') : null;

        $documents = PublicDocument::published()
            ->search($keyword)
            ->category($category)
            ->documentType($documentType)
            ->year($year)
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $years = PublicDocument::published()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $documentTypes = PublicDocument::published()
            ->select('document_type')
            ->distinct()
            ->pluck('document_type');

        return theme_view('ppid.documents', compact('documents', 'years', 'documentTypes', 'keyword', 'category', 'documentType', 'year'));
    }

    /**
     * Unduh berkas dokumen publik desa.
     */
    public function downloadDocument(PublicDocument $publicDocument): BinaryFileResponse|RedirectResponse
    {
        if (! $publicDocument->is_published) {
            abort(404, 'Dokumen publik tidak ditemukan atau belum dipublikasikan.');
        }

        $publicDocument->increment('download_count');

        $path = $publicDocument->file_path;
        if (! Storage::disk('public')->exists($path)) {
            return back()->with('error', 'Berkas fisik dokumen belum diunggah atau tidak ditemukan di penyimpanan server.');
        }

        return response()->download(
            Storage::disk('public')->path($path),
            $publicDocument->slug.'.'.($publicDocument->file_extension ?? 'pdf')
        );
    }

    /**
     * Formulir Pengajuan Permohonan Informasi Publik Daring.
     */
    public function createRequest(): View
    {
        return theme_view('ppid.create_request');
    }

    /**
     * Simpan Permohonan Informasi Publik Daring.
     */
    public function storeRequest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'applicant_name' => ['required', 'string', 'max:255'],
            'applicant_nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'applicant_phone' => ['required', 'string', 'max:25'],
            'applicant_email' => ['required', 'string', 'email', 'max:255'],
            'applicant_address' => ['required', 'string', 'max:1000'],
            'information_requested' => ['required', 'string', 'max:2000'],
            'purpose' => ['required', 'string', 'max:2000'],
            'acquisition_way' => ['required', 'in:online,direct_view,hardcopy'],
            'identity_card' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'applicant_name.required' => 'Nama lengkap pemohon wajib diisi.',
            'applicant_phone.required' => 'Nomor telepon/WhatsApp wajib diisi untuk konfirmasi status informasi.',
            'applicant_email.required' => 'Alamat email aktif wajib diisi.',
            'applicant_address.required' => 'Alamat lengkap tempat tinggal pemohon wajib diisi.',
            'information_requested.required' => 'Rincian informasi publik yang dibutuhkan wajib diisi.',
            'purpose.required' => 'Tujuan peruntukan penggunaan informasi wajib dijelaskan secara jelas.',
            'acquisition_way.required' => 'Pilih cara memperoleh salinan informasi publik.',
            'identity_card.max' => 'Ukuran berkas identitas maksimal 2MB.',
        ]);

        $identityPath = null;
        if ($request->hasFile('identity_card')) {
            $identityPath = $request->file('identity_card')->store('ppid_identities', 'public');
        }

        $ticketNumber = InformationRequest::generateTicketNumber();

        $infoRequest = InformationRequest::create([
            'ticket_number' => $ticketNumber,
            'applicant_name' => $validated['applicant_name'],
            'applicant_nik' => $validated['applicant_nik'] ?? null,
            'applicant_phone' => $validated['applicant_phone'],
            'applicant_email' => strtolower($validated['applicant_email']),
            'applicant_address' => $validated['applicant_address'],
            'identity_card_path' => $identityPath,
            'information_requested' => $validated['information_requested'],
            'purpose' => $validated['purpose'],
            'acquisition_way' => $validated['acquisition_way'],
            'status' => 'submitted',
            'user_id' => auth()->id() ?? null,
        ]);

        return redirect()->route('public.ppid.tracking.show', $ticketNumber)
            ->with('success', "Permohonan Informasi Publik berhasil diajukan dengan Nomor Tiket: {$ticketNumber}. Harap simpan nomor tiket ini untuk melacak status tanggapan PPID.");
    }

    /**
     * Halaman formulir lacak status tiket permohonan / keberatan.
     */
    public function tracking(): View
    {
        return theme_view('ppid.tracking');
    }

    /**
     * Proses pencarian tiket permohonan atau keberatan.
     */
    public function checkTracking(Request $request): RedirectResponse
    {
        $ticket = trim((string) $request->input('ticket_number'));

        if (empty($ticket)) {
            return back()->with('error', 'Masukkan nomor tiket permohonan (INF-...) atau keberatan (KBR-...).');
        }

        return redirect()->route('public.ppid.tracking.show', $ticket);
    }

    /**
     * Tampilkan detail status tiket permohonan atau keberatan.
     */
    public function showTracking(string $ticket): View
    {
        $ticket = strtoupper(trim($ticket));

        $infoRequest = InformationRequest::with(['objection', 'responder'])
            ->where('ticket_number', $ticket)
            ->first();

        $objection = null;
        if (! $infoRequest) {
            $objection = InformationObjection::with(['request.responder', 'responder'])
                ->where('ticket_number', $ticket)
                ->first();

            if (! $objection) {
                abort(404, "Nomor Tiket {$ticket} tidak ditemukan dalam arsip layanan informasi publik desa.");
            }

            $infoRequest = $objection->request;
        }

        return theme_view('ppid.tracking_show', compact('ticket', 'infoRequest', 'objection'));
    }

    /**
     * Formulir Pengajuan Keberatan Informasi Publik atas tiket permohonan yang ditolak / belum dijawab.
     */
    public function createObjection(string $ticket): View|RedirectResponse
    {
        $infoRequest = InformationRequest::where('ticket_number', $ticket)->firstOrFail();

        if ($infoRequest->objection) {
            return redirect()->route('public.ppid.tracking.show', $infoRequest->objection->ticket_number)
                ->with('info', "Keberatan untuk permohonan ini sudah diajukan sebelumnya dengan nomor tiket: {$infoRequest->objection->ticket_number}.");
        }

        return theme_view('ppid.create_objection', compact('infoRequest'));
    }

    /**
     * Simpan Pengajuan Keberatan Informasi Publik ke Atasan PPID (Kepala Desa).
     */
    public function storeObjection(Request $request, string $ticket): RedirectResponse
    {
        $infoRequest = InformationRequest::where('ticket_number', $ticket)->firstOrFail();

        if ($infoRequest->objection) {
            return redirect()->route('public.ppid.tracking.show', $infoRequest->objection->ticket_number);
        }

        $validated = $request->validate([
            'reason_code' => ['required', 'in:rejected,not_provided,not_responded,not_as_requested,excessive_fee,late_delivery'],
            'objection_detail' => ['required', 'string', 'max:2000'],
        ], [
            'reason_code.required' => 'Pilih alasan pengajuan keberatan sesuai ketentuan UU KIP.',
            'objection_detail.required' => 'Rincian atau kronologi alasan keberatan wajib diisi.',
        ]);

        $objectionTicket = InformationObjection::generateTicketNumber();

        $objection = InformationObjection::create([
            'ticket_number' => $objectionTicket,
            'information_request_id' => $infoRequest->id,
            'reason_code' => $validated['reason_code'],
            'objection_detail' => $validated['objection_detail'],
            'status' => 'submitted',
        ]);

        return redirect()->route('public.ppid.tracking.show', $objectionTicket)
            ->with('success', "Keberatan Informasi Publik berhasil diajukan kepada Atasan PPID (Kepala Desa) dengan Nomor Tiket: {$objectionTicket}.");
    }
}
