<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained('polls')->onDelete('cascade'); // Relasi ke polls
            $table->string('option_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_options');
    }
};