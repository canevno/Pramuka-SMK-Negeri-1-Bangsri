<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('petugas_absensis')) {
            return;
        }

        Schema::create('petugas_absensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nta')->unique();
            $table->string('kelas_petugas')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('terakhir_melakukan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas_absensis');
    }
};
