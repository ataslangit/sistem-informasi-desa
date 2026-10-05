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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_type', 50)->default('village');
            $table->string('tenant_id', 50)->default('1');
            $table->unsignedSmallInteger('year')->index();
            $table->string('title');
            $table->enum('status', ['draft', 'published', 'archived'])->default('published')->index();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['tenant_type', 'tenant_id', 'year']);
        });

        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained('budgets')->cascadeOnDelete();
            $table->enum('type', ['revenue', 'expenditure', 'financing'])->index();
            $table->string('category');
            $table->unsignedBigInteger('budgeted_amount')->default(0);
            $table->unsignedBigInteger('realized_amount')->default(0);
            $table->string('notes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_items');
        Schema::dropIfExists('budgets');
    }
};
