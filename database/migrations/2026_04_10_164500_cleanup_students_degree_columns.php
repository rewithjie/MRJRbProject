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
        if (Schema::hasColumn('students', 'degreee_id')) {
            DB::statement('UPDATE students SET degree_id = degreee_id WHERE degree_id IS NULL');

            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('degreee_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('students', 'degreee_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedBigInteger('degreee_id')->nullable()->after('degree_id');
            });
        }
    }
};
