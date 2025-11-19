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
        Schema::create('points_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['deposit', 'redemption', 'adjustment']);
            $table->integer('points'); // positive for earning, negative for spending
            $table->integer('balance')->default(0); // running balance after this transaction
            $table->text('description')->nullable();
            $table->unsignedBigInteger('deposit_id')->nullable();
            $table->unsignedBigInteger('redemption_id')->nullable();
            $table->timestamps();
            
            // Foreign keys without cascade (will be added after redemptions table exists)
            $table->foreign('deposit_id')->references('id')->on('deposits')->nullOnDelete();
            // Note: redemption_id foreign key will be added via separate migration after redemptions table exists
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_ledger');
    }
};