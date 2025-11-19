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
        Schema::table('points_ledger', function (Blueprint $table) {
            $table->foreign('redemption_id')->references('id')->on('redemptions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('points_ledger', function (Blueprint $table) {
            $table->dropForeign(['redemption_id']);
        });
    }
};
