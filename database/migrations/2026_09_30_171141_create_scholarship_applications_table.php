<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // PERBAIKAN TYPO DI BAWAH INI:
            $table->foreignId('scholarship_id')->constrained('scholarships')->cascadeOnDelete();
            
            $table->decimal('gpa_score', 3, 2);
            $table->string('document_file'); // File syarat awal mendaftar
            
            // PENAMBAHAN KOLOM BARU:
            $table->string('acceptance_proof_file')->nullable(); // Bukti SK/Pengumuman Lolos Resmi
            
            $table->enum('status', [
                'pending', 
                'verified_by_dosen', 
                'rejected_by_dosen', 
                'approved_by_admin', 
                'rejected_by_admin'
            ])->default('pending');
            
            $table->text('dosen_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_applications');
    }
};