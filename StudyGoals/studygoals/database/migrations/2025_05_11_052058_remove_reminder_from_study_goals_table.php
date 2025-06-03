<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('study_goals', function (Blueprint $table) {
        $table->dropColumn('reminder');
    });
}

public function down()
{
    Schema::table('study_goals', function (Blueprint $table) {
        $table->string('reminder')->nullable(); // Atau sesuai tipe aslinya
    });
}

};
