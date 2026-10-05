<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\VillageBoundary;
use App\Models\VillageFacility;
use Illuminate\Database\Seeder;

class VillageBudgetAndMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed APBDes 2024
        $budget = Budget::updateOrCreate(
            ['tenant_type' => 'village', 'tenant_id' => '1', 'year' => 2024],
            [
                'title' => 'Anggaran Pendapatan dan Belanja Desa (APBDes) Tahun Anggaran 2024',
                'status' => Budget::STATUS_PUBLISHED,
                'description' => 'Ringkasan publikasi transparansi anggaran pendapatan, belanja, dan pembiayaan Desa Sukamaju.',
            ]
        );

        $budget->items()->delete();

        $items = [
            // Pendapatan Desa (Akun 4)
            ['type' => 'revenue', 'sub_type' => 'pades', 'code' => '4.1', 'category' => 'Pendapatan Asli Desa (PADes)', 'budgeted_amount' => 85000000, 'realized_amount' => 87500000, 'sort_order' => 1],
            ['type' => 'revenue', 'sub_type' => 'transfer', 'code' => '4.2.1', 'category' => 'Dana Desa (DDS - APBN)', 'budgeted_amount' => 920000000, 'realized_amount' => 920000000, 'sort_order' => 2],
            ['type' => 'revenue', 'sub_type' => 'transfer', 'code' => '4.2.2', 'category' => 'Alokasi Dana Desa (ADD - APBD)', 'budgeted_amount' => 450000000, 'realized_amount' => 450000000, 'sort_order' => 3],
            ['type' => 'revenue', 'sub_type' => 'transfer', 'code' => '4.2.3', 'category' => 'Bagi Hasil Pajak & Retribusi (BHPR)', 'budgeted_amount' => 45000000, 'realized_amount' => 42500000, 'sort_order' => 4],
            ['type' => 'revenue', 'sub_type' => 'lain_lain', 'code' => '4.3', 'category' => 'Bantuan Keuangan Khusus & Lain-lain', 'budgeted_amount' => 25000000, 'realized_amount' => 25000000, 'sort_order' => 5],

            // 5 Bidang Belanja Baku (Akun 5 - Permendagri No. 20/2018)
            ['type' => 'expenditure', 'sub_type' => \App\Models\BudgetItem::BIDANG_PEMERINTAHAN, 'code' => '5.1', 'category' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'budgeted_amount' => 420000000, 'realized_amount' => 415000000, 'sort_order' => 1],
            ['type' => 'expenditure', 'sub_type' => \App\Models\BudgetItem::BIDANG_PEMBANGUNAN, 'code' => '5.2', 'category' => 'Bidang Pelaksanaan Pembangunan Desa', 'budgeted_amount' => 750000000, 'realized_amount' => 742000000, 'sort_order' => 2],
            ['type' => 'expenditure', 'sub_type' => \App\Models\BudgetItem::BIDANG_PEMBINAAN, 'code' => '5.3', 'category' => 'Bidang Pembinaan Kemasyarakatan Desa', 'budgeted_amount' => 135000000, 'realized_amount' => 131500000, 'sort_order' => 3],
            ['type' => 'expenditure', 'sub_type' => \App\Models\BudgetItem::BIDANG_PEMBERDAYAAN, 'code' => '5.4', 'category' => 'Bidang Pemberdayaan Masyarakat Desa', 'budgeted_amount' => 140000000, 'realized_amount' => 137000000, 'sort_order' => 4],
            ['type' => 'expenditure', 'sub_type' => \App\Models\BudgetItem::BIDANG_BENCANA_DARURAT, 'code' => '5.5', 'category' => 'Bidang Penanggulangan Bencana, Keadaan Darurat dan Mendesak Desa', 'budgeted_amount' => 80000000, 'realized_amount' => 79500000, 'sort_order' => 5],

            // Restrukturisasi Pembiayaan Desa (Akun 6 - Permendagri No. 20/2018)
            ['type' => 'financing', 'sub_type' => \App\Models\BudgetItem::FINANCING_RECEIPT, 'code' => '6.1.1', 'category' => 'Penerimaan Pembiayaan (SiLPA Tahun Lalu)', 'budgeted_amount' => 35000000, 'realized_amount' => 35000000, 'sort_order' => 1],
            ['type' => 'financing', 'sub_type' => \App\Models\BudgetItem::FINANCING_EXPENDITURE, 'code' => '6.2.1', 'category' => 'Pengeluaran Pembiayaan (Penyertaan Modal BUMDes)', 'budgeted_amount' => 35000000, 'realized_amount' => 35000000, 'sort_order' => 2],
        ];

        foreach ($items as $item) {
            $budget->items()->create($item);
        }

        // 2. Seed Batas Wilayah Desa & Dusun
        VillageBoundary::truncate();

        VillageBoundary::create([
            'name' => 'Batas Wilayah Desa Sukamaju',
            'type' => VillageBoundary::TYPE_VILLAGE,
            'color' => '#0284c7',
            'area_hectares' => 425.50,
            'description' => 'Batas terluar wilayah administratif Desa Sukamaju.',
            'coordinates' => [
                [-6.910000, 107.600000],
                [-6.908000, 107.620000],
                [-6.925000, 107.625000],
                [-6.928000, 107.602000],
                [-6.910000, 107.600000],
            ],
        ]);

        VillageBoundary::create([
            'name' => 'Wilayah Dusun 1 Sukamaju Utara',
            'type' => VillageBoundary::TYPE_DUSUN,
            'color' => '#10b981',
            'area_hectares' => 210.20,
            'description' => 'Meliputi RW 01, RW 02, dan kawasan pertanian terpadu.',
            'coordinates' => [
                [-6.910000, 107.600000],
                [-6.908000, 107.620000],
                [-6.917000, 107.622000],
                [-6.917000, 107.601000],
                [-6.910000, 107.600000],
            ],
        ]);

        VillageBoundary::create([
            'name' => 'Wilayah Dusun 2 Sukamaju Selatan',
            'type' => VillageBoundary::TYPE_DUSUN,
            'color' => '#f59e0b',
            'area_hectares' => 215.30,
            'description' => 'Meliputi RW 03, RW 04, dan sentra UMKM kerajinan.',
            'coordinates' => [
                [-6.917000, 107.601000],
                [-6.917000, 107.622000],
                [-6.925000, 107.625000],
                [-6.928000, 107.602000],
                [-6.917000, 107.601000],
            ],
        ]);

        // 3. Seed Titik Fasilitas & Infrastruktur Umum Desa
        VillageFacility::truncate();

        $facilities = [
            [
                'name' => 'Kantor Kepala Desa Sukamaju',
                'category' => 'pemerintahan',
                'latitude' => -6.914744,
                'longitude' => 107.609810,
                'address' => 'Jl. Raya Desa Sukamaju No. 01',
                'image_url' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Pusat pelayanan administrasi dan kantor pemerintahan desa.',
            ],
            [
                'name' => 'Puskesmas Pembantu (Pustu) Sukamaju',
                'category' => 'kesehatan',
                'latitude' => -6.916200,
                'longitude' => 107.612500,
                'address' => 'Jl. Melati No. 12 Dusun 1',
                'image_url' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Fasilitas pelayanan kesehatan dasar bagi warga desa.',
            ],
            [
                'name' => 'SD Negeri 1 Sukamaju',
                'category' => 'pendidikan',
                'latitude' => -6.912500,
                'longitude' => 107.606800,
                'address' => 'Jl. Pendidikan Dusun 1',
                'image_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Sekolah dasar negeri pusat kegiatan belajar anak desa.',
            ],
            [
                'name' => 'Masjid Jami Baiturrahman Sukamaju',
                'category' => 'ibadah',
                'latitude' => -6.915500,
                'longitude' => 107.610200,
                'address' => 'Kompleks Balai Warga RT 02/01',
                'image_url' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Masjid utama desa tempat ibadah dan pembinaan keagamaan.',
            ],
            [
                'name' => 'Pasar Tradisional & Kios UMKM Desa',
                'category' => 'ekonomi',
                'latitude' => -6.919000,
                'longitude' => 107.615000,
                'address' => 'Jl. Pasar Baru Dusun 2',
                'image_url' => 'https://images.unsplash.com/photo-1530507629858-e4977d30e9e0?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Pusat perdagangan hasil bumi dan kerajinan warga.',
            ],
            [
                'name' => 'Kawasan Wisata Agro & Taman Desa',
                'category' => 'wisata',
                'latitude' => -6.911200,
                'longitude' => 107.604500,
                'address' => 'Jl. Lembah Hijau Sukamaju',
                'image_url' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Destinasi wisata petik buah dan edukasi pertanian organik.',
            ],
            [
                'name' => 'Jembatan Gantung Penghubung Antar-Dusun',
                'category' => 'infrastruktur',
                'latitude' => -6.917500,
                'longitude' => 107.611000,
                'address' => 'Sungai Citarik Sukamaju',
                'image_url' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                'condition' => 'baik',
                'description' => 'Infrastruktur transportasi penyeberangan warga antar dusun.',
            ],
        ];

        foreach ($facilities as $facility) {
            VillageFacility::create($facility);
        }
    }
}
