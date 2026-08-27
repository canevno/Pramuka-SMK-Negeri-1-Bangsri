<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->date('record_date')->nullable()->after('tahun');
            $table->string('month_key')->nullable()->after('record_date');
            $table->string('year_key')->nullable()->after('month_key');
            $table->string('week_label')->nullable()->after('year_key');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['record_date', 'month_key', 'year_key', 'week_label']);
        });
    }
};