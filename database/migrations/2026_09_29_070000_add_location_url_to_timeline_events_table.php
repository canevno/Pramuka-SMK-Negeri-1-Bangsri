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
        Schema::table('timeline_events', function (Blueprint $table) {
            if (! Schema::hasColumn('timeline_events', 'location_url')) {
                $table->string('location_url')->nullable()->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timeline_events', function (Blueprint $table) {
            if (Schema::hasColumn('timeline_events', 'location_url')) {
                $table->dropColumn('location_url');
            }
        });
    }
};
