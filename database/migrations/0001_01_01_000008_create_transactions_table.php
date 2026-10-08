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
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_code')->unique();
                $table->string('midtrans_order_id')->nullable();
                $table->string('midtrans_transaction_id')->nullable();
                $table->string('snap_token')->nullable();
                $table->unsignedBigInteger('student_id')->index();
                $table->unsignedBigInteger('program_id')->index();
                $table->unsignedBigInteger('voucher_id')->nullable()->index();
                $table->decimal('amount', 15, 2);
                $table->decimal('discount_amount', 15, 2)->default(0);
                $table->string('payment_method')->nullable();
                $table->string('payment_proof')->nullable();
                $table->string('status')->default('pending')->index();
                $table->string('midtrans_status')->nullable();
                $table->json('midtrans_response')->nullable();
                $table->dateTime('payment_date')->nullable();
                $table->dateTime('expires_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
