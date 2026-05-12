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
        Schema::table('students', function (Blueprint $table) {
            // Drop the old column
            $table->dropColumn('course_and_section');
            
            // Add new columns
            $table->string('course'); // BSIT, BSCS, BSEMC
            $table->integer('year_level'); // 1, 2, 3, 4
            $table->string('block'); // A-Z
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn(['course', 'year_level', 'block']);
            
            // Restore the old column
            $table->string('course_and_section');
        });
    }
};
