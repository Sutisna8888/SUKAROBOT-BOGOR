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
        if (!Schema::hasTable('schedules')) {
            Schema::create('schedules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_program')->index();
                $table->date('tanggal_mulai')->nullable();
                $table->time('jam_mulai')->nullable();
                $table->date('tanggal_selesai')->nullable();
                $table->time('jam_selesai')->nullable();
                $table->string('ket')->default('Aktif')->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
