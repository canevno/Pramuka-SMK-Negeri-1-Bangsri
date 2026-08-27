<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('participant_id')->nullable();
            $table->string('participant_name');
            $table->string('participant_kelas');
            $table->string('ambalan')->nullable();
            $table->string('tanggal');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('status');
            $table->string('iuran')->default('Tidak');
            $table->string('petugas_name');
            $table->string('petugas_kelas');
            $table->string('petugas_nta');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};