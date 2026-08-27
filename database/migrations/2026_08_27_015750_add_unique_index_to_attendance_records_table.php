<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membatasi panjang karakter indeks agar tidak melebihi limit 3072 bytes
        DB::statement('ALTER TABLE attendance_records ADD UNIQUE unique_attendance_record (record_date, participant_name(100), participant_kelas(50), participant_ambalan(30))');
    }

    public function down(): void
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            $table->dropUnique('unique_attendance_record');
        });
    }
};