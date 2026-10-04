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
        Schema::create('resident_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->enum('type', ['birth', 'death', 'moved_out', 'moved_in'])->comment('Jenis Mutasi');
            $table->date('date')->comment('Tanggal Mutasi');
            $table->string('reason', 150)->nullable()->comment('Alasan Mutasi');
            $table->text('notes')->nullable()->comment('Keterangan Tambahan / Alamat Tujuan');
            $table->string('reference_number', 100)->nullable()->comment('Nomor Surat Keterangan / Berkas Pendukung');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['type', 'date']);
            $table->index('resident_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_mutations');
    }
};
