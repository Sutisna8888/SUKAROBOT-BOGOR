<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transactions') && !Schema::hasColumn('transactions', 'training_booking_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('training_booking_id')->nullable()->index()->after('program_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'training_booking_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('training_booking_id');
            });
        }
    }
};
