<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'participant_ambalan')) {
                $table->string('participant_ambalan')->nullable()->after('participant_kelas');
            }
            if (!Schema::hasColumn('attendances', 'record_date')) {
                $table->date('record_date')->nullable()->after('tahun');
            }
            if (!Schema::hasColumn('attendances', 'month_key')) {
                $table->string('month_key')->nullable()->after('record_date');
            }
            if (!Schema::hasColumn('attendances', 'year_key')) {
                $table->string('year_key')->nullable()->after('month_key');
            }
            if (!Schema::hasColumn('attendances', 'week_label')) {
                $table->string('week_label')->nullable()->after('year_key');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('attendances', 'participant_ambalan') ? 'participant_ambalan' : null,
                Schema::hasColumn('attendances', 'record_date') ? 'record_date' : null,
                Schema::hasColumn('attendances', 'month_key') ? 'month_key' : null,
                Schema::hasColumn('attendances', 'year_key') ? 'year_key' : null,
                Schema::hasColumn('attendances', 'week_label') ? 'week_label' : null,
            ]));
        });
    }
};