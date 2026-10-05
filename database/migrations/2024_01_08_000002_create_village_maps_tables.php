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
        Schema::create('village_boundaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['village', 'dusun', 'rw', 'rt'])->default('dusun')->index();
            $table->string('color', 20)->default('#0284c7');
            $table->json('coordinates');
            $table->decimal('area_hectares', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('village_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', [
                'pemerintahan',
                'kesehatan',
                'pendidikan',
                'ibadah',
                'ekonomi',
                'wisata',
                'infrastruktur',
            ])->default('pemerintahan')->index();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('address')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_facilities');
        Schema::dropIfExists('village_boundaries');
    }
};
