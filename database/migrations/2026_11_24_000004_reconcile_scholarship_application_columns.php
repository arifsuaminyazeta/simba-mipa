<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarship_applications', function (Blueprint $table) {
            if (! Schema::hasColumn('scholarship_applications', 'recommendation_letter_file')) {
                $table->string('recommendation_letter_file')->nullable();
            }

            if (! Schema::hasColumn('scholarship_applications', 'admin_notes')) {
                $table->text('admin_notes')->nullable();
            }

            if (! Schema::hasColumn('scholarship_applications', 'statement_file')) {
                $table->string('statement_file')->nullable();
            }

            if (! Schema::hasColumn('scholarship_applications', 'motivation_file')) {
                $table->string('motivation_file')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('scholarship_applications', function (Blueprint $table) {
            $columns = [];

            foreach ([
                'recommendation_letter_file',
                'admin_notes',
                'statement_file',
                'motivation_file',
            ] as $column) {
                if (Schema::hasColumn('scholarship_applications', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
