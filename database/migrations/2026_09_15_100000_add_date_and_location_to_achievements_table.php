<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            if (! Schema::hasColumn('achievements', 'date')) {
                $table->date('date')->nullable()->after('year');
            }

            if (! Schema::hasColumn('achievements', 'location')) {
                $table->string('location')->nullable()->after('date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            if (Schema::hasColumn('achievements', 'location')) {
                $table->dropColumn('location');
            }

            if (Schema::hasColumn('achievements', 'date')) {
                $table->dropColumn('date');
            }
        });
    }
};
