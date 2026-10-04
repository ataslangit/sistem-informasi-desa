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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('family_card_number', 16)->unique()->comment('Nomor Kartu Keluarga 16 digit');
            $table->unsignedBigInteger('head_of_family_id')->nullable()->comment('ID Kepala Keluarga');
            $table->text('address')->nullable();
            $table->string('rt', 5)->default('001');
            $table->string('rw', 5)->default('001');
            $table->string('hamlet', 50)->nullable()->comment('Dusun / Lingkungan');
            $table->string('postal_code', 10)->nullable();
            $table->string('social_assistance_status', 50)->nullable()->comment('Status Bansos: PKH, BPNT, BST, Tidak Ada');
            $table->string('economic_status', 50)->default('mampu')->comment('mampu, rentan, miskin, sangat_miskin');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['rt', 'rw', 'hamlet']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
