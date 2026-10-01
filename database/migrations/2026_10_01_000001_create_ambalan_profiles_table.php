<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambalan_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('type', 2)->unique(); // PA = Putra, PI = Putri
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('motto')->nullable();
            $table->text('description')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('leader_name')->nullable();
            $table->unsignedInteger('member_count')->nullable();
            $table->string('meeting_schedule')->nullable();
            $table->string('meeting_place')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ambalan_profiles');
    }
};