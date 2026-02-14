<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('source_url')->nullable()->after('thumbnail');
            $table->char('source_hash', 64)->nullable()->after('source_url')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique('posts_source_hash_unique');
            $table->dropColumn(['source_url', 'source_hash']);
        });
    }
};
