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
        if (!Schema::hasTable('data_programs')) {
            Schema::create('data_programs', function (Blueprint $table) {
                $table->id();
                $table->string('program');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->decimal('price', 15, 2)->default(0);
                $table->string('category')->nullable()->index();
                $table->string('type')->nullable();
                $table->string('image')->nullable();
                $table->string('zoom_link')->nullable();
                $table->string('status')->default('published')->index();
                $table->unsignedBigInteger('instructor_id')->nullable()->index();
                $table->integer('quota')->nullable();
                $table->integer('enrolled_count')->default(0);
                $table->decimal('rating', 3, 1)->default(0.0);
                $table->integer('total_reviews')->default(0);
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
                $table->json('learning_materials')->nullable();
                $table->json('benefits')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_programs');
    }
};
