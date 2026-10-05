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
        // 1. Tabel Dokumen Publik Desa (Daftar Informasi Publik - DIP Desa)
        Schema::create('public_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment('Judul Dokumen Publik');
            $table->string('slug', 255)->unique();
            $table->string('category', 50)->default('berkala')->comment('berkala, setiap_saat, serta_merta, dikecualikan');
            $table->string('document_type', 50)->default('Lainnya')->comment('RPJMDes, RKPDes, LPPD, LKPPD, APBDes, Perdes, SK Kades, dll');
            $table->smallInteger('year')->nullable()->comment('Tahun anggaran / penetapan');
            $table->text('description')->nullable();
            $table->string('file_path', 255)->comment('Lokasi berkas dokumen');
            $table->unsignedBigInteger('file_size')->nullable()->comment('Ukuran berkas dalam bytes');
            $table->string('file_extension', 10)->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'is_published']);
            $table->index('document_type');
            $table->index('year');
        });

        // 2. Tabel Permohonan Informasi Publik Daring (UU KIP No. 14/2008 & Perki No. 1/2018)
        Schema::create('information_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 30)->unique()->comment('Nomor Tiket: INF-YYYYMMDD-XXXX');
            $table->string('applicant_name', 255);
            $table->string('applicant_nik', 16)->nullable()->comment('NIK 16 digit pemohon (jika warga)');
            $table->string('applicant_phone', 25);
            $table->string('applicant_email', 255);
            $table->text('applicant_address');
            $table->string('identity_card_path', 255)->nullable()->comment('Foto/Scan KTP pemohon');
            $table->text('information_requested')->comment('Rincian informasi publik yang dibutuhkan');
            $table->text('purpose')->comment('Tujuan penggunaan informasi publik');
            $table->string('acquisition_way', 30)->default('online')->comment('online, direct_view, hardcopy');
            $table->string('status', 30)->default('submitted')->comment('submitted, processed, approved, rejected');
            $table->text('response_text')->nullable()->comment('Jawaban resmi PPID Desa');
            $table->string('response_file_path', 255)->nullable()->comment('Berkas jawaban yang diberikan');
            $table->text('rejection_reason')->nullable()->comment('Alasan penolakan jika permohonan ditolak');
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('ticket_number');
            $table->index('status');
            $table->index('created_at');
        });

        // 3. Tabel Keberatan Atas Permohonan Informasi Publik
        Schema::create('information_objections', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 30)->unique()->comment('Nomor Tiket: KBR-YYYYMMDD-XXXX');
            $table->foreignId('information_request_id')->constrained('information_requests')->cascadeOnDelete();
            $table->string('reason_code', 50)->comment('rejected, not_provided, not_responded, not_as_requested, excessive_fee, late_delivery');
            $table->text('objection_detail')->comment('Rincian atau kronologi keberatan pemohon');
            $table->string('status', 30)->default('submitted')->comment('submitted, reviewed, upheld, rejected');
            $table->text('response_text')->nullable()->comment('Keputusan / tanggapan Atasan PPID (Kepala Desa)');
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('ticket_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_objections');
        Schema::dropIfExists('information_requests');
        Schema::dropIfExists('public_documents');
    }
};
