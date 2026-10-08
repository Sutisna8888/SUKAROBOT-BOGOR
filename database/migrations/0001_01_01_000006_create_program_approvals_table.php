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
        if (!Schema::hasTable('program_approvals')) {
            Schema::create('program_approvals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('program_id')->nullable()->index();
                $table->unsignedBigInteger('instructor_id')->nullable()->index();
                $table->string('title');
                $table->string('category')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 15, 2)->default(0);
                $table->string('type')->nullable();
                $table->string('image')->nullable();
                $table->string('zoom_link')->nullable();
                $table->integer('quota')->nullable();
                $table->integer('available_slots')->nullable();
                $table->string('province')->nullable();
                $table->string('city')->nullable();
                $table->string('district')->nullable();
                $table->string('village')->nullable();
                $table->text('full_address')->nullable();
                $table->date('start_date')->nullable();
                $table->time('start_time')->nullable();
                $table->date('end_date')->nullable();
                $table->time('end_time')->nullable();
                $table->json('tools')->nullable();
                $table->json('materials')->nullable();
                $table->json('learning_materials')->nullable();
                $table->json('benefits')->nullable();
                $table->string('status')->default('pending')->index();
                $table->unsignedBigInteger('approved_by')->nullable()->index();
                $table->timestamp('approved_at')->nullable();
                $table->text('rejection_reason')->nullable();
                $table->timestamp('rejected_at')->nullable();
                $table->longText('lms_curriculum_json')->nullable();
                $table->longText('lms_assignment_json')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_approvals');
    }
};
