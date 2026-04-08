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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom untuk Google OAuth jika belum ada
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('password');
            }
            if (!Schema::hasColumn('users', 'google_token')) {
                $table->text('google_token')->nullable()->after('google_id');
            }
            if (!Schema::hasColumn('users', 'google_refresh_token')) {
                $table->text('google_refresh_token')->nullable()->after('google_token');
            }
            
            // Opsional: Tambahkan untuk GitHub OAuth
            if (!Schema::hasColumn('users', 'github_id')) {
                $table->string('github_id')->nullable()->unique()->after('google_refresh_token');
            }
            if (!Schema::hasColumn('users', 'github_token')) {
                $table->text('github_token')->nullable()->after('github_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['google_id']);
            $table->dropUnique(['github_id']);
            $table->dropColumn(['google_id', 'google_token', 'google_refresh_token', 'github_id', 'github_token']);
        });
    }
};