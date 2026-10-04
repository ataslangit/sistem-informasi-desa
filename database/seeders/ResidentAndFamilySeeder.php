<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Resident;
use App\Models\ResidentMutation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ResidentAndFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@sidesa.id')->first();
        $wargaUser = User::where('email', 'warga@sidesa.id')->first();

        // --- KELUARGA 1: Keluarga Budi Santoso (Dusun Sukamaju) ---
        $family1 = Family::create([
            'family_card_number' => '3201011202150001',
            'address' => 'Jl. Merpati No. 12',
            'rt' => '001',
            'rw' => '002',
            'hamlet' => 'Dusun Sukamaju',
            'postal_code' => '40123',
            'social_assistance_status' => null,
            'economic_status' => 'mampu',
        ]);

        $budi = Resident::create([
            'family_id' => $family1->id,
            'nik' => '3201011508900001',
            'name' => 'Budi Santoso',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(1990, 8, 15),
            'gender' => 'L',
            'blood_type' => 'O',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'S1/D4',
            'occupation' => 'Wiraswasta',
            'nationality' => 'WNI',
            'father_name' => 'Sukardi',
            'mother_name' => 'Siti Aminah',
            'status' => 'active',
            'user_id' => $wargaUser?->id,
        ]);
        $family1->update(['head_of_family_id' => $budi->id]);

        $dewi = Resident::create([
            'family_id' => $family1->id,
            'nik' => '3201015204920002',
            'name' => 'Dewi Lestari',
            'birth_place' => 'Bandung',
            'birth_date' => Carbon::create(1992, 4, 12),
            'gender' => 'P',
            'blood_type' => 'A',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Istri',
            'education_level' => 'SMA Sederajat',
            'occupation' => 'Mengurus Rumah Tangga',
            'nationality' => 'WNI',
            'father_name' => 'Hasan Basri',
            'mother_name' => 'Rohanah',
            'status' => 'active',
        ]);

        $rizky = Resident::create([
            'family_id' => $family1->id,
            'nik' => '3201011005180003',
            'name' => 'Rizky Pratama',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(2018, 5, 10),
            'gender' => 'L',
            'blood_type' => 'O',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'SD Sederajat',
            'occupation' => 'Pelajar',
            'nationality' => 'WNI',
            'father_name' => 'Budi Santoso',
            'mother_name' => 'Dewi Lestari',
            'status' => 'active',
        ]);

        $anisa = Resident::create([
            'family_id' => $family1->id,
            'nik' => '3201016508220004',
            'name' => 'Anisa Rahmawati',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(2022, 8, 25),
            'gender' => 'P',
            'blood_type' => 'A',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'Tidak/Belum Sekolah',
            'occupation' => 'Belum / Tidak Bekerja',
            'nationality' => 'WNI',
            'father_name' => 'Budi Santoso',
            'mother_name' => 'Dewi Lestari',
            'status' => 'active',
        ]);

        // Catat mutasi kelahiran Anisa
        ResidentMutation::create([
            'resident_id' => $anisa->id,
            'type' => 'birth',
            'date' => Carbon::create(2022, 8, 25),
            'reason' => 'Kelahiran anak kedua',
            'reference_number' => '472.11/08/DS/2022',
            'created_by' => $adminUser?->id,
        ]);

        // --- KELUARGA 2: Keluarga Pak RT Joko (Dusun Sukamaju) ---
        $family2 = Family::create([
            'family_card_number' => '3201011803120002',
            'address' => 'Jl. Kenanga No. 04',
            'rt' => '002',
            'rw' => '002',
            'hamlet' => 'Dusun Sukamaju',
            'postal_code' => '40123',
            'social_assistance_status' => null,
            'economic_status' => 'mampu',
        ]);

        $joko = Resident::create([
            'family_id' => $family2->id,
            'nik' => '3201011206700005',
            'name' => 'Joko Widodo Prasetyo',
            'birth_place' => 'Solo',
            'birth_date' => Carbon::create(1970, 6, 12),
            'gender' => 'L',
            'blood_type' => 'B',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'SMA Sederajat',
            'occupation' => 'Petani',
            'nationality' => 'WNI',
            'father_name' => 'Notomiharjo',
            'mother_name' => 'Sujiatmi',
            'status' => 'active',
        ]);
        $family2->update(['head_of_family_id' => $joko->id]);

        $sri = Resident::create([
            'family_id' => $family2->id,
            'nik' => '3201014510750006',
            'name' => 'Sri Wahyuni',
            'birth_place' => 'Klaten',
            'birth_date' => Carbon::create(1975, 10, 5),
            'gender' => 'P',
            'blood_type' => 'B',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Istri',
            'education_level' => 'SMA Sederajat',
            'occupation' => 'Pedagang',
            'nationality' => 'WNI',
            'father_name' => 'Hartono',
            'mother_name' => 'Sumarni',
            'status' => 'active',
        ]);

        $bayu = Resident::create([
            'family_id' => $family2->id,
            'nik' => '3201012301010007',
            'name' => 'Bayu Nugroho',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(2001, 1, 23),
            'gender' => 'L',
            'blood_type' => 'B',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'S1/D4',
            'occupation' => 'Karyawan Swasta',
            'nationality' => 'WNI',
            'father_name' => 'Joko Widodo Prasetyo',
            'mother_name' => 'Sri Wahyuni',
            'status' => 'active',
        ]);

        // --- KELUARGA 3: Keluarga Penerima PKH (Dusun Mekar Sari) ---
        $family3 = Family::create([
            'family_card_number' => '3201010509140003',
            'address' => 'Kp. Cijati RT 03/RW 01',
            'rt' => '003',
            'rw' => '001',
            'hamlet' => 'Dusun Mekar Sari',
            'postal_code' => '40123',
            'social_assistance_status' => 'PKH',
            'economic_status' => 'miskin',
        ]);

        $ujang = Resident::create([
            'family_id' => $family3->id,
            'nik' => '3201010403820008',
            'name' => 'Ujang Suryana',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(1982, 3, 4),
            'gender' => 'L',
            'blood_type' => 'O',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'SMP Sederajat',
            'occupation' => 'Buruh Harian Lepas',
            'nationality' => 'WNI',
            'father_name' => 'Mamat',
            'mother_name' => 'Neneng',
            'status' => 'active',
        ]);
        $family3->update(['head_of_family_id' => $ujang->id]);

        $eti = Resident::create([
            'family_id' => $family3->id,
            'nik' => '3201015607850009',
            'name' => 'Eti Sumiati',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(1985, 7, 16),
            'gender' => 'P',
            'blood_type' => 'O',
            'religion' => 'Islam',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Istri',
            'education_level' => 'SD Sederajat',
            'occupation' => 'Mengurus Rumah Tangga',
            'nationality' => 'WNI',
            'father_name' => 'Encep',
            'mother_name' => 'Sopiah',
            'status' => 'active',
        ]);

        $diki = Resident::create([
            'family_id' => $family3->id,
            'nik' => '3201011809120010',
            'name' => 'Diki Wahyudi',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(2012, 9, 18),
            'gender' => 'L',
            'blood_type' => 'O',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'SMP Sederajat',
            'occupation' => 'Pelajar',
            'nationality' => 'WNI',
            'father_name' => 'Ujang Suryana',
            'mother_name' => 'Eti Sumiati',
            'status' => 'active',
        ]);

        // Nenek Lansia di keluarga 3
        $makIjah = Resident::create([
            'family_id' => $family3->id,
            'nik' => '3201016101480011',
            'name' => 'Mak Ijah',
            'birth_place' => 'Bogor',
            'birth_date' => Carbon::create(1948, 1, 21),
            'gender' => 'P',
            'blood_type' => 'A',
            'religion' => 'Islam',
            'marital_status' => 'Cerai Mati',
            'family_relationship_status' => 'Orang Tua',
            'education_level' => 'Tidak/Belum Sekolah',
            'occupation' => 'Tidak Bekerja',
            'nationality' => 'WNI',
            'father_name' => 'Rahmat',
            'mother_name' => 'Maryati',
            'status' => 'active',
        ]);

        // --- KELUARGA 4: Warga Pindah Keluar & Meninggal (Dusun Harapan) ---
        $family4 = Family::create([
            'family_card_number' => '3201012511100004',
            'address' => 'Jl. Flamboyan No. 8',
            'rt' => '001',
            'rw' => '003',
            'hamlet' => 'Dusun Harapan',
            'postal_code' => '40123',
            'social_assistance_status' => null,
            'economic_status' => 'mampu',
        ]);

        $hendra = Resident::create([
            'family_id' => $family4->id,
            'nik' => '3201011402650012',
            'name' => 'Hendra Gunawan',
            'birth_place' => 'Jakarta',
            'birth_date' => Carbon::create(1965, 2, 14),
            'gender' => 'L',
            'blood_type' => 'AB',
            'religion' => 'Kristen',
            'marital_status' => 'Kawin',
            'family_relationship_status' => 'Kepala Keluarga',
            'education_level' => 'SMA Sederajat',
            'occupation' => 'Pensiunan',
            'nationality' => 'WNI',
            'father_name' => 'Gunawan',
            'mother_name' => 'Juliana',
            'status' => 'deceased',
        ]);

        // Catat kematian Hendra
        ResidentMutation::create([
            'resident_id' => $hendra->id,
            'type' => 'death',
            'date' => Carbon::now()->subMonths(1),
            'reason' => 'Sakit menua di RSUD',
            'notes' => 'Meninggal dunia di RSUD dan dimakamkan di TPU Desa',
            'reference_number' => '474.3/12/DS/2026',
            'created_by' => $adminUser?->id,
        ]);

        $kevin = Resident::create([
            'family_id' => $family4->id,
            'nik' => '3201012807950013',
            'name' => 'Kevin Gunawan',
            'birth_place' => 'Jakarta',
            'birth_date' => Carbon::create(1995, 7, 28),
            'gender' => 'L',
            'blood_type' => 'AB',
            'religion' => 'Kristen',
            'marital_status' => 'Belum Kawin',
            'family_relationship_status' => 'Anak',
            'education_level' => 'S1/D4',
            'occupation' => 'Programmer',
            'nationality' => 'WNI',
            'father_name' => 'Hendra Gunawan',
            'mother_name' => 'Maria',
            'status' => 'moved',
        ]);

        // Catat mutasi pindah keluar Kevin
        ResidentMutation::create([
            'resident_id' => $kevin->id,
            'type' => 'moved_out',
            'date' => Carbon::now()->subWeeks(2),
            'reason' => 'Pindah kerja ke Jakarta Selatan',
            'notes' => 'Pindah domisili ke Kec. Kebayoran Baru, Jakarta Selatan',
            'reference_number' => '475.1/02/DS/2026',
            'created_by' => $adminUser?->id,
        ]);
    }
}
