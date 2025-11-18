<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('unit')->default('kg'); // e.g., kg, pcs
            $table->float('points_per_unit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_types');
    }
};
