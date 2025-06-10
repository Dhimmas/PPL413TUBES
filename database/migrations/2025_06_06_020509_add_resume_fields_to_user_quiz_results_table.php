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
        Schema::table('user_quiz_results', function (Blueprint $table) {
        $table->timestamp('ends_at')->nullable()->after('finished_at');

        $table->foreignId('last_question_id')->nullable()->after('ends_at')->constrained('questions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {

        $table->dropForeign(['last_question_id']);
        $table->dropColumn(['ends_at', 'last_question_id']);
        });
    }
};
