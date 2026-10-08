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
        Schema::table('program_approvals', function (Blueprint $table) {
            if (!Schema::hasColumn('program_approvals', 'available_slots')) {
                $table->integer('available_slots')->nullable()->after('quota');
            }
            if (!Schema::hasColumn('program_approvals', 'materials')) {
                $table->json('materials')->nullable()->after('tools');
            }
            if (!Schema::hasColumn('program_approvals', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('program_approvals', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('program_approvals', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            }
            if (!Schema::hasColumn('program_approvals', 'lms_curriculum_json')) {
                $table->longText('lms_curriculum_json')->nullable()->after('rejected_at');
            }
            if (!Schema::hasColumn('program_approvals', 'lms_assignment_json')) {
                $table->longText('lms_assignment_json')->nullable()->after('lms_curriculum_json');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_approvals', function (Blueprint $table) {
            $columns = [
                'available_slots',
                'materials',
                'approved_by',
                'approved_at',
                'rejected_at',
                'lms_curriculum_json',
                'lms_assignment_json',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('program_approvals', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
