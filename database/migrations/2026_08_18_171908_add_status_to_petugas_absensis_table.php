<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPetugasAbsensisTable extends Migration
{
    public function up(): void
    {
        Schema::table('petugas_absensis', function (Blueprint $table) {
            if (! Schema::hasColumn('petugas_absensis', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('kelas_petugas');
            }
            if (! Schema::hasColumn('petugas_absensis', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_approved');
            }
            if (! Schema::hasColumn('petugas_absensis', 'terakhir_melakukan')) {
                $table->timestamp('terakhir_melakukan')->nullable()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('petugas_absensis', function (Blueprint $table) {
            if (Schema::hasColumn('petugas_absensis', 'terakhir_melakukan')) {
                $table->dropColumn('terakhir_melakukan');
            }
            if (Schema::hasColumn('petugas_absensis', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('petugas_absensis', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
        });
    }
}