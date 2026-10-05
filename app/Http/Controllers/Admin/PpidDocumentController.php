<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicDocument;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PpidDocumentController extends Controller
{
    /**
     * Menampilkan daftar Dokumen Publik (Daftar Informasi Publik - DIP Desa).
     */
    public function index(Request $request): View
    {
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $documentType = $request->input('document_type');
        $year = $request->filled('year') ? (int) $request->input('year') : null;

        $documents = PublicDocument::with('user')
            ->search($keyword)
            ->category($category)
            ->documentType($documentType)
            ->year($year)
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $documentTypes = ['RPJMDes', 'RKPDes', 'LPPD', 'LKPPD', 'APBDes', 'Perdes', 'SK Kades', 'Lainnya'];
        $categories = [
            'berkala' => 'Informasi Berkala',
            'setiap_saat' => 'Informasi Setiap Saat',
            'serta_merta' => 'Informasi Serta Merta',
            'dikecualikan' => 'Informasi Dikecualikan',
        ];

        return view('admin.ppid.documents.index', compact('documents', 'documentTypes', 'categories', 'keyword', 'category', 'documentType', 'year'));
    }

    /**
     * Formulir tambah dokumen publik baru.
     */
    public function create(): View
    {
        $documentTypes = ['RPJMDes', 'RKPDes', 'LPPD', 'LKPPD', 'APBDes', 'Perdes', 'SK Kades', 'Lainnya'];
        $categories = [
            'berkala' => 'Informasi Berkala (Wajib Berkala: RPJMDes, RKPDes, LPPD, dll)',
            'setiap_saat' => 'Informasi Setiap Saat (DIP, SK Kades, Perdes)',
            'serta_merta' => 'Informasi Serta Merta (Bencana, Darurat)',
            'dikecualikan' => 'Informasi Dikecualikan (Data Rahasia / Terbatas)',
        ];

        return view('admin.ppid.documents.create', compact('documentTypes', 'categories'));
    }

    /**
     * Simpan dokumen publik baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:berkala,setiap_saat,serta_merta,dikecualikan'],
            'document_type' => ['required', 'string', 'max:50'],
            'year' => ['nullable', 'integer', 'digits:4'],
            'description' => ['nullable', 'string', 'max:1000'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul dokumen publik wajib diisi.',
            'category.required' => 'Klasifikasi informasi KIP wajib dipilih.',
            'document_type.required' => 'Tipe dokumen wajib ditentukan.',
            'file.required' => 'Berkas dokumen wajib diunggah.',
            'file.max' => 'Ukuran berkas maksimal 10MB.',
            'file.mimes' => 'Format berkas hanya diperbolehkan PDF, DOC/DOCX, XLS/XLSX, atau ZIP.',
        ]);

        $uploadedFile = $request->file('file');
        $fileName = Str::slug($validated['title']).'-'.time().'.'.$uploadedFile->getClientOriginalExtension();
        $filePath = $uploadedFile->storeAs('ppid_documents', $fileName, 'public');

        $isPublished = $request->boolean('is_published', true);

        PublicDocument::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(5),
            'category' => $validated['category'],
            'document_type' => $validated['document_type'],
            'year' => $validated['year'] ? (int) $validated['year'] : null,
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_size' => $uploadedFile->getSize(),
            'file_extension' => strtolower($uploadedFile->getClientOriginalExtension()),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen publik berhasil diunggah ke repositori PPID Desa.');
    }

    /**
     * Form edit dokumen publik.
     */
    public function edit(PublicDocument $ppidDocument): View
    {
        $documentTypes = ['RPJMDes', 'RKPDes', 'LPPD', 'LKPPD', 'APBDes', 'Perdes', 'SK Kades', 'Lainnya'];
        $categories = [
            'berkala' => 'Informasi Berkala',
            'setiap_saat' => 'Informasi Setiap Saat',
            'serta_merta' => 'Informasi Serta Merta',
            'dikecualikan' => 'Informasi Dikecualikan',
        ];

        return view('admin.ppid.documents.edit', compact('ppidDocument', 'documentTypes', 'categories'));
    }

    /**
     * Perbarui dokumen publik.
     */
    public function update(Request $request, PublicDocument $ppidDocument): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:berkala,setiap_saat,serta_merta,dikecualikan'],
            'document_type' => ['required', 'string', 'max:50'],
            'year' => ['nullable', 'integer', 'digits:4'],
            'description' => ['nullable', 'string', 'max:1000'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $isPublished = $request->boolean('is_published', true);

        $data = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'document_type' => $validated['document_type'],
            'year' => $validated['year'] ? (int) $validated['year'] : null,
            'description' => $validated['description'] ?? null,
            'is_published' => $isPublished,
            'published_at' => $isPublished && ! $ppidDocument->published_at ? now() : $ppidDocument->published_at,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($ppidDocument->file_path && Storage::disk('public')->exists($ppidDocument->file_path)) {
                Storage::disk('public')->delete($ppidDocument->file_path);
            }

            $uploadedFile = $request->file('file');
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$uploadedFile->getClientOriginalExtension();
            $data['file_path'] = $uploadedFile->storeAs('ppid_documents', $fileName, 'public');
            $data['file_size'] = $uploadedFile->getSize();
            $data['file_extension'] = strtolower($uploadedFile->getClientOriginalExtension());
        }

        $ppidDocument->update($data);

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen publik berhasil diperbarui.');
    }

    /**
     * Hapus dokumen publik (Soft Delete).
     */
    public function destroy(PublicDocument $ppidDocument): RedirectResponse
    {
        $ppidDocument->delete();

        return redirect()->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen publik berhasil dihapus dari repositori.');
    }
}
