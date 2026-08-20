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
        Schema::table('attendance_records', function (Blueprint $table) {
            $table->string('week_label')->nullable()->after('tanggal');
            $table->string('month_key')->nullable()->after('week_label');
            $table->string('year_key')->nullable()->after('month_key');
            $table->string('record_date')->nullable()->after('year_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            $table->dropColumn(['week_label', 'month_key', 'year_key', 'record_date']);
        });
    }
};
