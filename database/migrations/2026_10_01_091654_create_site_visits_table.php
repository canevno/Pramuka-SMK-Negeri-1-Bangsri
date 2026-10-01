<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date')->index();
            $table->string('visitor_hash', 64);          // hash IP + user agent (anonim)
            $table->unsignedInteger('hits')->default(1); // jumlah halaman dibuka pada hari itu
            $table->string('last_path')->nullable();
            $table->timestamps();

            // 1 pengunjung = 1 baris per hari
            $table->unique(['visit_date', 'visitor_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};