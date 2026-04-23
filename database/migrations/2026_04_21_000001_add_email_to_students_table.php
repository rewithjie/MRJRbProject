<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('students', 'email')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('email')->nullable()->after('lname');
            });
        }

        // Backfill from linked user accounts when available.
        DB::statement("\n            UPDATE students s\n            JOIN user_accounts ua ON ua.id = s.user_account_id\n            SET s.email = ua.email\n            WHERE s.email IS NULL OR s.email = ''\n        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('students', 'email')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
};
