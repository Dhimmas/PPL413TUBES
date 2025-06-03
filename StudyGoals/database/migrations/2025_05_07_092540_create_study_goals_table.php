<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateS extends Migration
{
    public function up()
    {
        Schema::create('study_goals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['In Progress', 'Completed'])->default('In Progress');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_goals');
    }
}

