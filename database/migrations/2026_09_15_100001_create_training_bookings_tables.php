<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('training_bookings')) {
            Schema::create('training_bookings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('student_id')->index();
                $table->unsignedBigInteger('program_id')->index();
                $table->string('schedule_status')->default('pending_admin')->index();
                $table->unsignedTinyInteger('training_days');
                $table->decimal('daily_price', 15, 2);
                $table->decimal('total_amount', 15, 2);
                $table->unsignedBigInteger('approved_by')->nullable()->index();
                $table->dateTime('approved_at')->nullable();
                $table->text('admin_notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('training_booking_dates')) {
            Schema::create('training_booking_dates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('training_booking_id')->index();
                $table->date('training_date');
                $table->unsignedBigInteger('trainer_id')->nullable()->index();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->timestamps();
                $table->unique(['training_booking_id', 'training_date']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('training_booking_dates');
        Schema::dropIfExists('training_bookings');
    }
};
