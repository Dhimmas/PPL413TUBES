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
        Schema::create('comment_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comment_id')->constrained()->onDelete('cascade');
            $table->string('reaction_type');
            $table->boolean('is_click')->default(true); // Hapus after()
            $table->timestamps();
            
            // Memastikan user hanya bisa memberikan satu jenis reaksi per komentar
            $table->unique(['user_id', 'comment_id', 'reaction_type']);
        });
    }

    /**
     * Reverse the migrations.
     * 
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reactions');
    }
};