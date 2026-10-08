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
        Schema::table('article_views', function (Blueprint $table) {
            if (!Schema::hasColumn('article_views', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('article_id')->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_views', function (Blueprint $table) {
            if (Schema::hasColumn('article_views', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
