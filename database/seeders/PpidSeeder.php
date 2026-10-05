<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PublicDocument;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PpidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@sidesa.id')->first() ?? User::first();
        $userId = $adminUser?->id;

        // Pastikan direktori ppid_documents ada di disk public
        if (! Storage::disk('public')->exists('ppid_documents')) {
            Storage::disk('public')->makeDirectory('ppid_documents');
        }

        // Minimal valid PDF content
        $dummyPdf = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 595 842]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000052 00000 n\n0000000101 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n178\n%%EOF\n";

        $samplePdfPath = 'ppid_documents/sample-dokumen-publik.pdf';
        Storage::disk('public')->put($samplePdfPath, $dummyPdf);
        $fileSize = strlen($dummyPdf);

        $documents = [
            [
                'title' => 'Rencana Kerja Pemerintah Desa (RKPDes) Tahun 2024',
                'category' => 'berkala',
                'document_type' => 'RKPDes',
                'year' => 2024,
                'description' => 'Dokumen rencana kerja pemerintah desa tahun anggaran 2024 yang memuat arah kebijakan dan program prioritas pembangunan desa.',
                'file_path' => $samplePdfPath,
                'file_size' => $fileSize,
                'file_extension' => 'pdf',
                'download_count' => 45,
                'is_published' => true,
                'published_at' => now()->subMonths(3),
            ],
            [
                'title' => 'Laporan Penyelenggaraan Pemerintahan Desa (LPPD) Akhir Tahun Anggaran 2023',
                'category' => 'berkala',
                'document_type' => 'LPPD',
                'year' => 2023,
                'description' => 'Laporan pertanggungjawaban akhir tahun pelaksanaan program kerja dan akuntabilitas kinerja Pemerintah Desa tahun anggaran 2023.',
                'file_path' => $samplePdfPath,
                'file_size' => $fileSize,
                'file_extension' => 'pdf',
                'download_count' => 38,
                'is_published' => true,
                'published_at' => now()->subMonths(6),
            ],
            [
                'title' => 'Laporan Realisasi Pelaksanaan APBDes Tahun Anggaran 2023',
                'category' => 'berkala',
                'document_type' => 'APBDes',
                'year' => 2023,
                'description' => 'Transparansi realisasi pendapatan, belanja, dan pembiayaan Anggaran Pendapatan dan Belanja Desa (APBDes) tahun anggaran 2023.',
                'file_path' => $samplePdfPath,
                'file_size' => $fileSize,
                'file_extension' => 'pdf',
                'download_count' => 62,
                'is_published' => true,
                'published_at' => now()->subMonths(5),
            ],
            [
                'title' => 'Peraturan Desa No. 03 Tahun 2022 tentang Susunan Organisasi dan Tata Kerja (SOTK)',
                'category' => 'setiap_saat',
                'document_type' => 'Perdes',
                'year' => 2022,
                'description' => 'Peraturan Desa mengenai struktur organisasi, tugas pokok, fungsi, dan wewenang perangkat desa dalam tata kelola pemerintahan.',
                'file_path' => $samplePdfPath,
                'file_size' => $fileSize,
                'file_extension' => 'pdf',
                'download_count' => 29,
                'is_published' => true,
                'published_at' => now()->subMonths(12),
            ],
            [
                'title' => 'Standar Operasional Prosedur (SOP) Layanan Administrasi Kependudukan & Surat Desa',
                'category' => 'setiap_saat',
                'document_type' => 'Lainnya',
                'year' => 2023,
                'description' => 'Panduan alur, syarat, batas waktu, dan mekanisme pengurusan surat keterangan dan dokumen kependudukan warga desa.',
                'file_path' => $samplePdfPath,
                'file_size' => $fileSize,
                'file_extension' => 'pdf',
                'download_count' => 54,
                'is_published' => true,
                'published_at' => now()->subMonths(8),
            ],
            [
                'title' => 'Surat Edaran Kewaspadaan Dini Bencana Banjir dan Cuaca Ekstrem Musim Penghujan',
                'category' => 'serta_merta',
                'document_type' => 'SK Kades',
                'year' => 2024,
                'description' => 'Informasi darurat serta merta mengenai panduan mitigasi, posko tanggap siaga, dan kontak darurat evakuasi bencana lingkungan.',
                'file_path' => $samplePdfPath,
                'file_size' => $fileSize,
                'file_extension' => 'pdf',
                'download_count' => 87,
                'is_published' => true,
                'published_at' => now()->subWeeks(2),
            ],
        ];

        foreach ($documents as $doc) {
            PublicDocument::updateOrCreate(
                ['title' => $doc['title']],
                array_merge($doc, [
                    'slug' => Str::slug($doc['title']),
                    'user_id' => $userId,
                ])
            );
        }
    }
}
