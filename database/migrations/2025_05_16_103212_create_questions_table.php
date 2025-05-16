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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // Relasi ke quiz
            $table->text('question_text')->nullable(); // Isi soal (bisa teks)
            $table->string('question_file')->nullable(); // path file soal
            $table->string('file_type')->nullable();
            $table->string('image')->nullable(); // URL atau path gambar soal
            $table->string('correct_answer'); // Jawaban benar
            $table->json('options')->nullable(); // Array pilihan ganda (opsional)
            $table->enum('question_type', ['multiple_choice', 'short_answer', 'file_based'])->default('multiple_choice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
