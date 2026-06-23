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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            // Columns
            $table->string('code', 50)->unique()
                ->comment('Kode kupon unik');

            $table->enum('discount_type', ['percent', 'fixed'])
                ->default('percent')
                ->comment('Tipe diskon: percent atau fixed');

            $table->decimal('discount_value', 15, 2)
                ->comment('Nilai diskon');

            $table->decimal('min_order', 15, 2)
                ->default(0)
                ->comment('Minimum pembelian untuk menggunakan kupon');

            $table->timestamp('expires_at')->nullable()
                ->comment('Tanggal kadaluarsa kupon');

            $table->unsignedInteger('usage_limit')->nullable()
                ->comment('Batasan penggunaan kupon (NULL = unlimited)');

            $table->unsignedInteger('used_count')
                ->default(0)
                ->comment('Jumlah kupon yang sudah digunakan');

            $table->boolean('is_active')
                ->default(true)
                ->comment('Status aktif/non-aktif kupon');

            $table->timestamps();

            // ── Indexes ────────────────────────────────────────────
            // Index untuk pencarian kode kupon
            $table->index(['code']);

            // Index untuk filter berdasarkan tanggal kadaluarsa (saat validasi)
            $table->index(['expires_at']);

            // Index untuk filter berdasarkan status aktif
            $table->index(['is_active']);

            // Composite index untuk pencarian kupon yang masih berlaku
            $table->index(['is_active', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
