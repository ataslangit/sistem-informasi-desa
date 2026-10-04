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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->nullable()->constrained('families')->onDelete('set null');
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan 16 digit');
            $table->string('name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P'])->comment('L = Laki-laki, P = Perempuan');
            $table->string('blood_type', 5)->default('-')->comment('A, B, AB, O, -');
            $table->string('religion', 30)->default('Islam');
            $table->string('marital_status', 30)->default('Belum Kawin');
            $table->string('family_relationship_status', 50)->default('Kepala Keluarga')->comment('Kepala Keluarga, Istri, Anak, Orang Tua, dll');
            $table->string('education_level', 50)->default('SMA Sederajat');
            $table->string('occupation', 100)->default('Belum / Tidak Bekerja');
            $table->string('nationality', 10)->default('WNI');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->enum('status', ['active', 'moved', 'deceased', 'temporary'])->default('active');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('gender');
            $table->index('birth_date');
            $table->index(['family_id', 'status']);
        });

        // Tambahkan foreign key head_of_family_id ke tabel families
        Schema::table('families', function (Blueprint $table) {
            $table->foreign('head_of_family_id')->references('id')->on('residents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->dropForeign(['head_of_family_id']);
        });

        Schema::dropIfExists('residents');
    }
};
