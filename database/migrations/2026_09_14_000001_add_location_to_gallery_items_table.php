<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (! Schema::hasColumn('gallery_items', 'location')) {
                $table->string('location')->nullable()->after('group');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'location')) {
                $table->dropColumn('location');
            }
        });
    }
};
