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
     * Penerapan standar UU No. 1/2024 (ITE) & PP No. 71/2019 (PSTE):
     * - Penyelenggaraan Sertifikasi Elektronik (TTE Tersertifikasi / BSrE BSSN)
     * - Integritas Dokumen (Cryptographic SHA-256 Document Hash)
     * - Digital Signature Token & Sertifikat Elektronik X.509
     * - Digital Timestamping (TSA)
     */
    public function up(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->enum('signature_type', ['uncertified', 'certified'])->default('certified')->after('signed_at')->index();
            $table->string('tte_provider', 50)->default('bsre_bssn')->after('signature_type')->index();
            $table->string('certificate_issuer', 255)->nullable()->after('tte_provider');
            $table->string('certificate_serial_number', 100)->nullable()->after('certificate_issuer')->index();
            $table->string('document_hash', 64)->nullable()->after('certificate_serial_number')->index();
            $table->string('signature_hash', 128)->nullable()->after('document_hash');
            $table->string('signer_name', 255)->nullable()->after('signature_hash');
            $table->string('signer_nip', 50)->nullable()->after('signer_name');
            $table->string('signer_nik', 16)->nullable()->after('signer_nip');
            $table->string('signer_position', 100)->nullable()->after('signer_nik');
            $table->dateTime('tte_timestamp')->nullable()->after('signer_position');
            $table->boolean('is_tampered')->default(false)->after('tte_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropIndex(['signature_type']);
            $table->dropIndex(['tte_provider']);
            $table->dropIndex(['certificate_serial_number']);
            $table->dropIndex(['document_hash']);

            $table->dropColumn([
                'signature_type',
                'tte_provider',
                'certificate_issuer',
                'certificate_serial_number',
                'document_hash',
                'signature_hash',
                'signer_name',
                'signer_nip',
                'signer_nik',
                'signer_position',
                'tte_timestamp',
                'is_tampered',
            ]);
        });
    }
};
