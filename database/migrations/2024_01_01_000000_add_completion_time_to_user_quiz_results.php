<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {
            $table->decimal('completion_time_minutes', 8, 2)->nullable()->after('finished_at');
        });
        Schema::table('user_quiz_results', function (Blueprint $table) {
            $table->timestamp('finished_at')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('user_quiz_results', function (Blueprint $table) {
            $table->dropColumn('completion_time_minutes');
        });
    }
};
