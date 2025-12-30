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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_tr');
            $table->string('slug_en')->unique();
            $table->string('slug_tr')->unique();
            $table->string('short_description_en');
            $table->string('short_description_tr');
            $table->longText('content_en');
            $table->longText('content_tr');
            $table->json('tech_stack')->nullable();
            $table->json('urls')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
