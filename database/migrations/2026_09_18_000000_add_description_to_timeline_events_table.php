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
        if (Schema::hasTable('timeline_events') && ! Schema::hasColumn('timeline_events', 'description')) {
            Schema::table('timeline_events', function (Blueprint $table) {
                $table->text('description')->nullable()->after('theme');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('timeline_events') && Schema::hasColumn('timeline_events', 'description')) {
            Schema::table('timeline_events', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
