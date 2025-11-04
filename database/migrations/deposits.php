<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // warga
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete(); // lokasi setoran
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->float('total_weight')->default(0);
            $table->unsignedInteger('total_points')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
