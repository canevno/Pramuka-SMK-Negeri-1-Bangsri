<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'jabatan')) {
                $table->string('jabatan')->nullable()->after('ambalan');
            }

            if (! Schema::hasColumn('students', 'status')) {
                $table->string('status')->default('Aktif')->after('jabatan');
            }

            if (! Schema::hasColumn('students', 'photo_url')) {
                $table->string('photo_url')->nullable()->after('status');
            }

            if (! Schema::hasColumn('students', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('photo_url');
            }

            if (! Schema::hasColumn('students', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'sort_order')) {
                $table->dropColumn('sort_order');
            }

            if (Schema::hasColumn('students', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('students', 'photo_url')) {
                $table->dropColumn('photo_url');
            }

            if (Schema::hasColumn('students', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('students', 'jabatan')) {
                $table->dropColumn('jabatan');
            }
        });
    }
};
