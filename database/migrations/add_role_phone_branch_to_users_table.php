<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Make migration idempotent: only add columns/foreign keys if they don't already exist
        if (! Schema::hasColumn('users', 'phone') || ! Schema::hasColumn('users', 'role') || ! Schema::hasColumn('users', 'branch_id')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable();
                }

                if (! Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['warga', 'admin_cabang', 'super_admin'])->default('warga');
                }

                if (! Schema::hasColumn('users', 'branch_id')) {
                    // create nullable branch_id column without adding a foreign key constraint here
                    // (some environments run migrations alphabetically and branches table may not exist yet)
                    $table->unsignedBigInteger('branch_id')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Drop only if the columns/foreign exist
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'branch_id')) {
                // use dropConstrainedForeignId if available, otherwise drop column
                try {
                    $table->dropConstrainedForeignId('branch_id');
                } catch (Throwable $e) {
                    $table->dropColumn('branch_id');
                }
            }
        });
    }
};
