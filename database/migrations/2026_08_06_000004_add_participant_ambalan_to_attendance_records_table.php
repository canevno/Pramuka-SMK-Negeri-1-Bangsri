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
        if (! Schema::hasColumn('attendance_records', 'participant_ambalan')) {
            Schema::table('attendance_records', function (Blueprint $table) {
                $table->string('participant_ambalan')->nullable()->after('participant_kelas');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('attendance_records', 'participant_ambalan')) {
            Schema::table('attendance_records', function (Blueprint $table) {
                $table->dropColumn('participant_ambalan');
            });
        }
    }
};
