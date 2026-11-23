<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_tracers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->enum('employment_status', [
                'bekerja',
                'studi_lanjut',
                'wirausaha',
                'mencari_kerja',
            ])->nullable();
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('city')->nullable();
            $table->integer('waiting_months')->nullable();
            $table->boolean('ready_for_sharing')->default(false);
            $table->string('contact_linkedin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_tracers');
    }
};