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
        Schema::create('point_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('deposit_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('redemption_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['credit', 'debit']); // credit = tambah poin, debit = kurang poin
            $table->decimal('amount', 10, 2); // Jumlah poin
            $table->decimal('balance_after', 10, 2); // Saldo setelah transaksi
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_ledgers');
    }
};
