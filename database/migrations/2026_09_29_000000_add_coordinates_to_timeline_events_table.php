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
        if (Schema::hasTable('timeline_events')) {
            Schema::table('timeline_events', function (Blueprint $table) {
                if (! Schema::hasColumn('timeline_events', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()->after('location');
                }

                if (! Schema::hasColumn('timeline_events', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('timeline_events')) {
            Schema::table('timeline_events', function (Blueprint $table) {
                if (Schema::hasColumn('timeline_events', 'latitude')) {
                    $table->dropColumn('latitude');
                }

                if (Schema::hasColumn('timeline_events', 'longitude')) {
                    $table->dropColumn('longitude');
                }
            });
        }
    }
};
