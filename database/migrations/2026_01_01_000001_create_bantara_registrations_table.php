<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel pendaftaran Bantara.
     */
    public function up(): void
    {
        Schema::create('bantara_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
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
            $table->string('surat_izin_path'); // Menyoimpan path file surat izin
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Membatalkan migrasi (menghapus tabel).
     */
    public function down(): void
    {
        Schema::dropIfExists('bantara_registrations');
    }
};