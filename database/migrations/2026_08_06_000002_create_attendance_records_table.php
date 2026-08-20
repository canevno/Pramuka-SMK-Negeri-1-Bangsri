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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('participant_id')->nullable();
            $table->string('participant_name');
            $table->string('participant_kelas');
            $table->string('participant_ambalan');
            $table->string('status');
            $table->string('iuran')->default('Tidak');
            $table->string('bulan');
            $table->string('tanggal');
            $table->string('tahun');
            $table->string('petugas_name');
            $table->string('petugas_kelas');
            $table->string('petugas_nta');
            $table->timestamps();

            $table->index(['bulan', 'tahun', 'participant_kelas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
