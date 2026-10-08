<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('training_bookings') && !Schema::hasColumn('training_bookings', 'locked_at')) {
            Schema::table('training_bookings', function (Blueprint $table) {
                $table->dateTime('locked_at')->nullable()->index()->after('approved_at');
                $table->unsignedBigInteger('locked_by_transaction_id')->nullable()->index()->after('locked_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('training_bookings') && Schema::hasColumn('training_bookings', 'locked_at')) {
            Schema::table('training_bookings', function (Blueprint $table) {
                $table->dropColumn(['locked_at', 'locked_by_transaction_id']);
            });
        }
    }
};
