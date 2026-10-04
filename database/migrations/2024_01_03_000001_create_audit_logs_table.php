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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 100)->comment('Nama Peristiwa Audit (cth: ResidentCreated, FamilyUpdated)');
            $table->string('entity_type', 50)->comment('Tipe Entitas (cth: resident, family, user)');
            $table->string('entity_id', 100)->comment('ID Entitas yang bersangkutan');
            $table->unsignedBigInteger('actor_id')->nullable()->comment('User ID pelaku perubahan');
            $table->json('old_values')->nullable()->comment('Nilai sebelum perubahan');
            $table->json('new_values')->nullable()->comment('Nilai sesudah perubahan');
            $table->string('ip_address', 45)->nullable()->comment('IP Address pelaku');
            $table->string('user_agent', 255)->nullable()->comment('User Agent browser pelaku');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['entity_type', 'entity_id'], 'idx_entity');
            $table->index('actor_id', 'idx_actor');
            $table->index('event_name', 'idx_event');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
