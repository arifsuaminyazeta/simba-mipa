<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semester_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('scholarship_id')->constrained('scholarships')->cascadeOnDelete();
            $table->integer('semester_ke');
            $table->decimal('ips_score', 3, 2);
            $table->decimal('ipk_score', 3, 2);
            $table->string('khs_file');
            $table->enum('verification_status', ['pending', 'verified', 'revision'])->default('pending');
            $table->enum('ews_status', ['aman', 'warning', 'kritis', 'revoked'])->default('aman');
            $table->text('evaluator_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semester_evaluations');
    }
};