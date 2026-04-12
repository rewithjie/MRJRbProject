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
        if (!Schema::hasTable('course__students')) {
            Schema::create('course__students', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('student_id');
                $table->timestamps();

                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            });

            return;
        }

        Schema::table('course__students', function (Blueprint $table) {
            if (!Schema::hasColumn('course__students', 'course_id')) {
                $table->unsignedBigInteger('course_id')->after('id');
            }

            if (!Schema::hasColumn('course__students', 'student_id')) {
                $table->unsignedBigInteger('student_id')->after('course_id');
            }
        });

        $dbName = DB::getDatabaseName();
        $fkCourse = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'course__students'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
              AND CONSTRAINT_NAME = 'course__students_course_id_foreign'
        ", [$dbName]);

        if (!$fkCourse) {
            DB::statement('ALTER TABLE course__students ADD CONSTRAINT course__students_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE');
        }

        $fkStudent = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'course__students'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
              AND CONSTRAINT_NAME = 'course__students_student_id_foreign'
        ", [$dbName]);

        if (!$fkStudent) {
            DB::statement('ALTER TABLE course__students ADD CONSTRAINT course__students_student_id_foreign FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left empty to avoid destructive rollback on pivot table.
    }
};
