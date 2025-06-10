<?php



// database/migrations/2025_05_23_103457_create_progress_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgTable extends Migration
{
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->foreignId('study_goal_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel study_goals
            $table->date('date'); // Kolom untuk tanggal
            $table->enum('status', ['Checked', 'Not Checked'])->default('Not Checked'); // Status untuk mencatat apakah tugas selesai atau belum
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('progress'); // Jika migrasi dihapus, tabel progress akan dihapus
    }
}
