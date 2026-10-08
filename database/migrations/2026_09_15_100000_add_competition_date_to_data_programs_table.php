<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('data_programs') && !Schema::hasColumn('data_programs', 'competition_date')) {
            Schema::table('data_programs', function (Blueprint $table) {
                $table->date('competition_date')->nullable()->after('end_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('data_programs') && Schema::hasColumn('data_programs', 'competition_date')) {
            Schema::table('data_programs', function (Blueprint $table) {
                $table->dropColumn('competition_date');
            });
        }
    }
};
