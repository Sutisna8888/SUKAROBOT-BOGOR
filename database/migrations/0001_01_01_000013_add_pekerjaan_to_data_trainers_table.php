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
        if (Schema::hasTable('data_trainers') && !Schema::hasColumn('data_trainers', 'pekerjaan')) {
            Schema::table('data_trainers', function (Blueprint $table) {
                $table->string('pekerjaan')->nullable()->after('keahlian');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('data_trainers') && Schema::hasColumn('data_trainers', 'pekerjaan')) {
            Schema::table('data_trainers', function (Blueprint $table) {
                $table->dropColumn('pekerjaan');
            });
        }
    }
};
