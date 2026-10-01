<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider'); 
            $table->decimal('min_gpa', 3, 2); 
            $table->integer('quota'); // Kuota maksimal awal
            $table->integer('remaining_quota'); // Sisa kuota berjalan
            $table->date('open_date');
            $table->date('close_date');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};