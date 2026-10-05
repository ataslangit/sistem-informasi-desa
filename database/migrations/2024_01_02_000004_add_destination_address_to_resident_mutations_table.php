<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('resident_mutations', function (Blueprint $table) {
            $table->string('target_province', 100)->nullable()->after('reason')->comment('Provinsi Tujuan Pindah');
            $table->string('target_regency', 100)->nullable()->after('target_province')->comment('Kabupaten/Kota Tujuan Pindah');
            $table->string('target_district', 100)->nullable()->after('target_regency')->comment('Kecamatan Tujuan Pindah');
            $table->string('target_village', 100)->nullable()->after('target_district')->comment('Desa/Kelurahan Tujuan Pindah');
            $table->string('target_address')->nullable()->after('target_village')->comment('Alamat Jalan / RT / RW Tujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident_mutations', function (Blueprint $table) {
            $table->dropColumn([
                'target_province',
                'target_regency',
                'target_district',
                'target_village',
                'target_address',
            ]);
        });
    }
};
