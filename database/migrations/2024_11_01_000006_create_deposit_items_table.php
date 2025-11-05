<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('deposit_items')) {
            Schema::create('deposit_items', function (Blueprint $table) {
            $table->id();
            // create foreign key columns as unsignedBigInteger to avoid ordering issues
            $table->unsignedBigInteger('deposit_id');
            $table->unsignedBigInteger('waste_type_id');
            $table->float('weight');
            $table->unsignedInteger('points')->default(0);
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('deposit_items');
    }
};
