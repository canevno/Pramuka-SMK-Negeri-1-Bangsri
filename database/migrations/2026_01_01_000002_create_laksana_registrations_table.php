<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laksana_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nta');
            $table->string('kelas');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('tempat_tanggal_lahir');
            $table->text('motivasi');
            $table->string('whatsapp', 20);
            $table->string('nomor_orang_tua', 20);
            $table->string('surat_izin_path');
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laksana_registrations');
    }
};
