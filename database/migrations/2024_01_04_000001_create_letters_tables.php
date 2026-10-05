<?php

declare(strict_types=1);

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
        Schema::create('letter_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique()->comment('Kode unik template, cth: SKTM, SKCK, DOMISILI');
            $table->string('name', 150)->comment('Nama resmi surat, cth: Surat Keterangan Tidak Mampu');
            $table->text('description')->nullable()->comment('Deskripsi dan kegunaan surat');
            $table->longText('content_template')->comment('Isi format template dengan placeholder');
            $table->json('required_fields')->nullable()->comment('Daftar kolom isian tambahan yang dibutuhkan dari warga');
            $table->boolean('is_active')->default(true)->comment('Status keaktifan template');
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });

        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number', 40)->unique()->comment('Nomor unik permohonan, cth: REQ-20261004-0001');
            $table->string('letter_number', 80)->nullable()->comment('Nomor registrasi surat resmi dari desa');
            $table->foreignId('letter_template_id')->constrained('letter_templates')->cascadeOnDelete();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('purpose')->comment('Tujuan / keperluan permohonan surat');
            $table->json('extra_data')->nullable()->comment('Data input tambahan sesuai konfigurasi template');
            $table->enum('status', [
                'pending_rt',
                'pending_staff',
                'pending_kades',
                'approved',
                'rejected',
            ])->default('pending_rt')->comment('Status tahapan alur persetujuan surat');

            // Tahap 1: Verifikasi RT/RW
            $table->timestamp('rt_verified_at')->nullable();
            $table->foreignId('rt_verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rt_notes')->nullable();

            // Tahap 2: Verifikasi Staf Desa
            $table->timestamp('staff_verified_at')->nullable();
            $table->foreignId('staff_verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('staff_notes')->nullable();

            // Tahap 3: Persetujuan & TTE Kepala Desa
            $table->timestamp('kades_approved_at')->nullable();
            $table->foreignId('kades_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('kades_notes')->nullable();

            // Penolakan
            $table->text('rejection_reason')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('rejected_at')->nullable();

            // Verifikasi Digital & QR Code
            $table->string('qr_token', 64)->unique()->comment('Token acak unik untuk verifikasi keaslian via scan QR');
            $table->timestamp('signed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index('resident_id');
            $table->index('user_id');
            $table->index('letter_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_requests');
        Schema::dropIfExists('letter_templates');
    }
};
