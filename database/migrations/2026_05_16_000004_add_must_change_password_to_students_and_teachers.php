<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'must_change_password')) {
                $table->boolean('must_change_password')->default(true)->after('password');
            }
        });

        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'must_change_password')) {
                $table->boolean('must_change_password')->default(true)->after('password');
            }
        });

        DB::table('students')->whereNull('must_change_password')->update(['must_change_password' => true]);
        DB::table('teachers')->whereNull('must_change_password')->update(['must_change_password' => true]);
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'must_change_password')) {
                $table->dropColumn('must_change_password');
            }
        });

        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'must_change_password')) {
                $table->dropColumn('must_change_password');
            }
        });
    }
};
