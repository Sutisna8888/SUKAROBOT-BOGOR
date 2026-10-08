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
        if (!Schema::hasTable('certificate_templates')) {
            Schema::create('certificate_templates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('program_id')->unique();
                $table->string('number_prefix')->nullable();
                $table->text('description')->nullable();
                $table->string('template_path');
                $table->boolean('is_active')->default(true);
                $table->float('name_x')->default(50);
                $table->float('name_y')->default(50);
                $table->float('desc_x')->default(50);
                $table->float('desc_y')->default(60);
                $table->float('number_x')->default(50);
                $table->float('number_y')->default(40);
                $table->float('date_x')->default(50);
                $table->float('date_y')->default(70);
                $table->integer('name_font_size')->default(32);
                $table->integer('desc_font_size')->default(16);
                $table->integer('number_font_size')->default(14);
                $table->integer('date_font_size')->default(14);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('template_id')->nullable()->index();
                $table->unsignedBigInteger('program_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedBigInteger('proof_id')->nullable()->index();
                $table->string('recipient_name');
                $table->string('certificate_number')->unique();
                $table->string('certificate_file')->nullable();
                $table->date('issued_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('certificate_templates');
    }
};
