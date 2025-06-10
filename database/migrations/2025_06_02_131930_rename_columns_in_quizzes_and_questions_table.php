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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->renameColumn('default_time_limit_per_question', 'time_limit_per_quiz')->nullable()->change();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('time_limit', 'time_limit_per_question')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->renameColumn('time_limit_per_quiz', 'default_time_limit_per_question')->nullable()->change();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->renameColumn('time_limit_per_question', 'time_limit')->nullable()->change();
        });
    }
};
