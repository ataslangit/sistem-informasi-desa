<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom sub_type dan code ke budget_items untuk kepatuhan Permendagri No. 20/2018:
     * - sub_type: klasifikasi 5 bidang belanja (bidang_1 s.d. bidang_5) atau pos pembiayaan (receipt / expenditure)
     * - code: kode rekening baku anggaran (misal: 5.1, 6.1.1, 6.2.1)
     */
    public function up(): void
    {
        Schema::table('budget_items', function (Blueprint $table) {
            $table->string('sub_type', 50)->nullable()->after('type')->index();
            $table->string('code', 50)->nullable()->after('sub_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_items', function (Blueprint $table) {
            $table->dropColumn(['sub_type', 'code']);
        });
    }
};
