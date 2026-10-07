<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationObjection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PpidObjectionController extends Controller
{
    /**
     * Daftar Keberatan Informasi Publik yang diajukan pemohon.
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $status = $request->input('status');

        $objections = InformationObjection::with(['request', 'responder'])
            ->search($keyword)
            ->status($status)
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'total' => InformationObjection::count(),
            'submitted' => InformationObjection::where('status', 'submitted')->count(),
            'reviewed' => InformationObjection::where('status', 'reviewed')->count(),
            'upheld' => InformationObjection::where('status', 'upheld')->count(),
            'rejected' => InformationObjection::where('status', 'rejected')->count(),
        ];

        return view('admin.ppid.objections.index', compact('objections', 'keyword', 'status', 'counts'));
    }

    /**
     * Detail keberatan informasi publik beserta data permohonan asalnya.
     */
    public function show(InformationObjection $ppidObjection): View
    {
        $ppidObjection->load(['request.responder', 'responder']);

        return view('admin.ppid.objections.show', compact('ppidObjection'));
    }

    /**
     * Tanggapan dan keputusan resmi Atasan PPID (Kepala Desa) atas keberatan.
     */
    public function respond(Request $request, InformationObjection $ppidObjection): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:upheld,rejected,reviewed'],
            'response_text' => ['required', 'string', 'max:5000'],
        ], [
            'status.required' => 'Pilih keputusan atas keberatan (Diterima / Ditolak / Ditinjau).',
            'response_text.required' => 'Pertimbangan atau tanggapan resmi Atasan PPID wajib diisi.',
        ]);

        $ppidObjection->update([
            'status' => $validated['status'],
            'response_text' => $validated['response_text'],
            'responded_at' => now(),
            'responded_by' => auth()->id(),
        ]);

        // Jika keberatan diterima oleh Kepala Desa, perintahkan pembukaan kembali permohonan ke status 'processed'
        // agar PPID Desa (Sekdes/Petugas) dapat menindaklanjuti dan mengunggah dokumen yang diminta.
        if ($validated['status'] === 'upheld') {
            $ppidObjection->request->update([
                'status' => 'processed',
            ]);
        }

        return back()->with('success', "Tanggapan resmi Atasan PPID atas tiket keberatan {$ppidObjection->ticket_number} berhasil disimpan.");
    }
}
