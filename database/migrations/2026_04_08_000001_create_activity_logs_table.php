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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action')->index(); // created, updated, deleted, failed_validation
            $table->string('entity_type')->index(); // Student, Degree, etc.
            $table->unsignedBigInteger('entity_id')->nullable()->index();
            $table->string('user_email')->nullable();
            $table->string('message');
            $table->json('data')->nullable(); // additional context
            $table->string('ip_address')->nullable();
            $table->string('status')->default('success'); // success, error, warning
            $table->timestamps();

            $table->index(['created_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
