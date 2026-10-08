<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add audit fields used when an admin accepts a program proof.
     */
    public function up(): void
    {
        Schema::table('program_proofs', function (Blueprint $table) {
            $table->unsignedBigInteger('accepted_by')->nullable()->after('status');
            $table->timestamp('accepted_at')->nullable()->after('accepted_by');
        });
    }

    /**
     * Remove the acceptance audit fields.
     */
    public function down(): void
    {
        Schema::table('program_proofs', function (Blueprint $table) {
            $table->dropColumn(['accepted_by', 'accepted_at']);
        });
    }
};
