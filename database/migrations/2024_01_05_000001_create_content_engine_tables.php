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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_type', 50)->nullable()->comment('Tipe tenant/lingkup (cth: village, null = global)');
            $table->string('tenant_id', 100)->nullable()->comment('ID tenant/lingkup (null = global)');
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete()->comment('ID User pembuat/penulis');
            $table->string('type', 30)->comment('page, post, testimonial, faq, gallery');
            $table->string('title', 255);
            $table->string('slug', 255)->nullable();
            $table->string('summary', 500)->nullable()->comment('Ringkasan / excerpt konten');
            $table->longText('body')->nullable()->comment('Isi konten HTML / teks');
            $table->json('meta')->nullable()->comment('Metadata fleksibel (SEO, gambar utama/cover, rating, dll)');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_type', 'tenant_id', 'type', 'status'], 'idx_tenant_content');
            $table->index(['author_id', 'status'], 'idx_author_content');
            $table->index(['type', 'status', 'published_at'], 'idx_type_status_published');
            $table->index(['slug', 'type'], 'idx_slug_type');
            $table->index(['type', 'sort_order'], 'idx_sort');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('type', 30)->default('category')->comment('category, tag, group');
            $table->timestamps();
        });

        Schema::create('content_category', function (Blueprint $table) {
            $table->foreignId('content_id')->constrained('contents')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->primary(['content_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_category');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('contents');
    }
};
