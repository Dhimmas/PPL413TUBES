<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {
            if (!Schema::hasColumn('user_quiz_results', 'is_finalized')) {
                $table->boolean('is_finalized')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {
            $table->dropColumn('is_finalized');
        });
    }
};
