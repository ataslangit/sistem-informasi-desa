<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Permendagri No. 1/2016 tentang Pengelolaan Aset Desa:
     * - Status Hak Kepemilikan (TKD, APBDes, Hibah, Bantuan Pemerintah Pusat/Daerah, Lainnya yang Sah)
     * - Klasifikasi Kode Register Inventaris Barang (KIB A s.d. F)
     * - Luas, Nilai Aset, dan Tahun Perolehan
     */
    public function up(): void
    {
        Schema::table('village_facilities', function (Blueprint $table) {
            $table->boolean('is_village_asset')->default(false)->after('condition')->index();
            $table->enum('kib_type', [
                'kib_a', // Tanah
                'kib_b', // Peralatan dan Mesin
                'kib_c', // Gedung dan Bangunan
                'kib_d', // Jalan, Irigasi dan Jaringan
                'kib_e', // Aset Tetap Lainnya
                'kib_f', // Konstruksi dalam Pengerjaan
            ])->nullable()->after('is_village_asset')->index();
            $table->enum('ownership_status', [
                'tanah_kas_desa',   // Kekayaan Asli Desa / Tanah Kas Desa (TKD)
                'apbdes',            // Beban APBDes
                'hibah',             // Hibah / Sumbangan Pihak Ketiga
                'pemerintah_pusat',  // Bantuan Pemerintah Pusat
                'pemerintah_daerah', // Bantuan Pemerintah Daerah (Provinsi / Kab / Kota)
                'lainnya_sah',       // Perolehan Lain yang Sah
            ])->nullable()->after('kib_type')->index();
            $table->string('register_code', 100)->nullable()->after('ownership_status')->index();
            $table->decimal('surface_area', 12, 2)->nullable()->after('register_code');
            $table->unsignedSmallInteger('acquisition_year')->nullable()->after('surface_area');
            $table->decimal('asset_value', 15, 2)->nullable()->after('acquisition_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('village_facilities', function (Blueprint $table) {
            $table->dropIndex(['is_village_asset']);
            $table->dropIndex(['kib_type']);
            $table->dropIndex(['ownership_status']);
            $table->dropIndex(['register_code']);

            $table->dropColumn([
                'is_village_asset',
                'kib_type',
                'ownership_status',
                'register_code',
                'surface_area',
                'acquisition_year',
                'asset_value',
            ]);
        });
    }
};
