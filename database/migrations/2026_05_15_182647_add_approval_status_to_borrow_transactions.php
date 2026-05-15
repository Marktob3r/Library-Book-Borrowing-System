<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrow_transactions', function (Blueprint $table) {
            // Add columns to track who rejected/approved and optional notes
            $table->string('rejected_reason')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('rejected_reason');
        });

        // Update existing 'Borrowed' records to match the new status vocabulary
        // (existing records stay 'Borrowed' — they were already approved by old flow)
    }

    public function down(): void
    {
        Schema::table('borrow_transactions', function (Blueprint $table) {
            $table->dropColumn(['rejected_reason', 'approved_at']);
        });
    }
};
