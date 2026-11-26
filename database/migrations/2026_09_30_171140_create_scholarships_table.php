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
            $table->text('description')->nullable();
            $table->string('registration_url');
            $table->decimal('min_gpa', 3, 2);
            $table->integer('quota')->nullable();
            $table->date('open_date');
            $table->date('close_date');
            $table->enum('status', ['open', 'upcoming', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};