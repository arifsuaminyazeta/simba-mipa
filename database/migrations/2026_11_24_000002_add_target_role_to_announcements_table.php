<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('announcements', 'target_role')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->string('target_role')->default('all')->after('content');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('announcements', 'target_role')) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->dropColumn('target_role');
            });
        }
    }
};
