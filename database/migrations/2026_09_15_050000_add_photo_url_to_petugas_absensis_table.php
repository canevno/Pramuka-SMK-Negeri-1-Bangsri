<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('petugas_absensis')) {
            return;
        }

        Schema::table('petugas_absensis', function (Blueprint $table) {
            if (! Schema::hasColumn('petugas_absensis', 'photo_url')) {
                $table->string('photo_url')->nullable()->after('kelas_petugas');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('petugas_absensis')) {
            return;
        }

        Schema::table('petugas_absensis', function (Blueprint $table) {
            if (Schema::hasColumn('petugas_absensis', 'photo_url')) {
                $table->dropColumn('photo_url');
            }
        });
    }
};
