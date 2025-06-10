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
    Schema::create('goal_progress', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('study_goal_id'); // Kolom untuk relasi dengan study_goal
        $table->date('date'); // Tanggal progres
        $table->enum('status', ['Checked', 'Incomplete']); // Status progres
        $table->timestamps();

        // Menambahkan foreign key constraint ke tabel study_goals
        $table->foreign('study_goal_id')->references('id')->on('study_goals')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('goal_progress');
}

};
