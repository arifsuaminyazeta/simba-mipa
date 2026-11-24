<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('semester_evaluations', function (Blueprint $table) {
            if (! Schema::hasColumn('semester_evaluations', 'ipk_score')) {
                $table->decimal('ipk_score', 3, 2)->nullable();
            }

            if (! Schema::hasColumn('semester_evaluations', 'verification_status')) {
                $table->string('verification_status')->default('pending');
            }

            if (! Schema::hasColumn('semester_evaluations', 'ews_status')) {
                $table->string('ews_status')->default('aman');
            }
        });

        if (Schema::hasColumn('semester_evaluations', 'status')) {
            DB::table('semester_evaluations')
                ->where('status', 'verified')
                ->update(['verification_status' => 'verified']);

            DB::table('semester_evaluations')
                ->where('status', 'warning')
                ->update(['ews_status' => 'warning']);
        }
    }

    public function down(): void
    {
        Schema::table('semester_evaluations', function (Blueprint $table) {
            $columns = [];

            foreach (['ipk_score', 'verification_status', 'ews_status'] as $column) {
                if (Schema::hasColumn('semester_evaluations', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
