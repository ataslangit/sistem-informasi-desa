<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PpidRequestController extends Controller
{
    /**
     * Daftar Permohonan Informasi Publik Daring.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $status = $request->input('status');

        $requests = InformationRequest::with(['objection', 'responder'])
            ->search($keyword)
            ->status($status)
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'total' => InformationRequest::count(),
            'submitted' => InformationRequest::where('status', 'submitted')->count(),
            'processed' => InformationRequest::where('status', 'processed')->count(),
            'approved' => InformationRequest::where('status', 'approved')->count(),
            'rejected' => InformationRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.ppid.requests.index', compact('requests', 'keyword', 'status', 'counts'));
    }

    /**
     * Detail permohonan informasi publik.
     */
    public function show(InformationRequest $ppidRequest): View
    {
        $ppidRequest->load(['objection.responder', 'responder', 'user']);

        return view('admin.ppid.requests.show', compact('ppidRequest'));
    }

    /**
     * Tandai permohonan sedang ditelaah / diproses oleh PPID.
     */
    public function process(InformationRequest $ppidRequest): RedirectResponse
    {
        $ppidRequest->update([
            'status' => 'processed',
        ]);

        return back()->with('success', "Permohonan tiket {$ppidRequest->ticket_number} kini berstatus: Sedang Diproses.");
    }

    /**
     * Setujui permohonan informasi publik dan berikan jawaban / dokumen.
     */
    public function approve(Request $request, InformationRequest $ppidRequest): RedirectResponse
    {
        $validated = $request->validate([
            'response_text' => ['required', 'string', 'max:5000'],
            'response_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
        ], [
            'response_text.required' => 'Penjelasan atau rincian jawaban informasi publik wajib diisi.',
            'response_file.max' => 'Ukuran berkas jawaban maksimal 10MB.',
        ]);

        $filePath = $ppidRequest->response_file_path;
        if ($request->hasFile('response_file')) {
            $uploaded = $request->file('response_file');
            $fileName = 'response-'.Str::slug($ppidRequest->ticket_number).'-'.time().'.'.$uploaded->getClientOriginalExtension();
            $filePath = $uploaded->storeAs('ppid_responses', $fileName, 'public');
        }

        $ppidRequest->update([
            'status' => 'approved',
            'response_text' => $validated['response_text'],
            'response_file_path' => $filePath,
            'rejection_reason' => null,
            'responded_at' => now(),
            'responded_by' => auth()->id(),
        ]);

        return back()->with('success', "Permohonan tiket {$ppidRequest->ticket_number} berhasil disetujui dan jawaban resmi telah disimpan.");
    }

    /**
     * Tolak permohonan informasi publik dengan alasan resmi UU KIP.
     */
    public function reject(Request $request, InformationRequest $ppidRequest): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:5000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan tertulis wajib diisi sesuai dasar hukum UU No. 14 Tahun 2008.',
        ]);

        $ppidRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'responded_at' => now(),
            'responded_by' => auth()->id(),
        ]);

        return back()->with('success', "Permohonan tiket {$ppidRequest->ticket_number} telah ditolak dengan alasan resmi.");
    }
}
