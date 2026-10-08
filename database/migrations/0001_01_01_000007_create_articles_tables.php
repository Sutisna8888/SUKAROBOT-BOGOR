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
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->longText('content');
                $table->text('excerpt')->nullable();
                $table->string('category')->nullable()->index();
                $table->string('image')->nullable();
                $table->boolean('is_published')->default(true)->index();
                $table->dateTime('published_at')->nullable();
                $table->unsignedBigInteger('author_id')->nullable()->index();
                $table->integer('views')->default(0);
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('article_views')) {
            Schema::create('article_views', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('article_id')->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->dateTime('viewed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_views');
        Schema::dropIfExists('articles');
    }
};
