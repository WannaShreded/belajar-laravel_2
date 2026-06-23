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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            // Columns
            $table->unsignedTinyInteger('rating')
                ->comment('Rating dari 1-5');

            $table->text('comment')->nullable();

            $table->timestamps();

            // ── Indexes ────────────────────────────────────────────
            // Index untuk WHERE clause
            $table->index(['user_id']);
            $table->index(['product_id']);

            // Composite index untuk query yang melibatkan user dan product
            $table->index(['product_id', 'user_id']);

            // Index untuk sorting by recent
            $table->index(['created_at']);

            // Unique constraint untuk satu review per user per product
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
