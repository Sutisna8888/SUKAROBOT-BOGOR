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
        if (!Schema::hasTable('data_trainers')) {
            Schema::create('data_trainers', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email')->nullable()->index();
                $table->string('telephone')->nullable();
                $table->string('keahlian')->nullable();
                $table->string('pekerjaan')->nullable();
                $table->string('status_trainer')->default('Aktif')->index();
                $table->string('pengalaman')->nullable();
                $table->text('bio')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_trainers');
    }
};
