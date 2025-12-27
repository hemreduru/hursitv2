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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_tr');
            $table->string('slug_en')->unique();
            $table->string('slug_tr')->unique();
            $table->string('short_description_en')->nullable();
            $table->string('short_description_tr')->nullable();
            $table->longText('content_en');
            $table->longText('content_tr');
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('reading_time')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
