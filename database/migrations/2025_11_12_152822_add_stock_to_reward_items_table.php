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
        Schema::table('reward_items', function (Blueprint $table) {
            // Cek apakah kolom stock sudah ada
            if (!Schema::hasColumn('reward_items', 'stock')) {
                $table->integer('stock')->default(0)->after('points_cost');
            }
            // Tambahkan kolom description dan image jika belum ada
            if (!Schema::hasColumn('reward_items', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('reward_items', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reward_items', function (Blueprint $table) {
            $table->dropColumn(['stock', 'description', 'image']);
        });
    }
};
