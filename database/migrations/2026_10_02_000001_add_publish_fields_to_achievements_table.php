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
            if (! Schema::hasColumn('achievements', 'detail_url')) {
                $table->text('detail_url')->nullable()->after('image');
            }

            if (! Schema::hasColumn('achievements', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('detail_url');
            }

            if (! Schema::hasColumn('achievements', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            if (Schema::hasColumn('achievements', 'published_at')) {
                $table->dropColumn('published_at');
            }

            if (Schema::hasColumn('achievements', 'is_published')) {
                $table->dropColumn('is_published');
            }

            if (Schema::hasColumn('achievements', 'detail_url')) {
                $table->dropColumn('detail_url');
            }
        });
    }
};
