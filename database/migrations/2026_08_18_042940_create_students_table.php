<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kelas_asal')->nullable();
            $table->string('sangga')->nullable();
            $table->string('sub_sangga')->nullable();
            $table->enum('ambalan', ['PA', 'PI'])->nullable();
            $table->string('jabatan')->nullable();
            $table->string('status')->default('Aktif');
            $table->string('photo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};