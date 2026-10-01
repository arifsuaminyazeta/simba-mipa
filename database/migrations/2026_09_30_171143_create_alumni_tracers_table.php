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
        Schema::create('alumni_tracers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('city')->nullable();
            $table->integer('waiting_months')->default(0); 
            
            // Indikator kesediaan jadi narasumber
            $table->boolean('ready_for_sharing')->default(false); 
            $table->string('contact_linkedin')->nullable();
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_tracers');
    }
};
