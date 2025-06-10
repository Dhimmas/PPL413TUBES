<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_option_id')->constrained('poll_options')->onDelete('cascade'); // Relasi ke poll_options
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke users
            $table->timestamps();

            // Opsional: Pastikan pengguna hanya bisa vote sekali per polling (lebih kompleks, bisa dihandle di logic atau dengan unique constraint di poll_id dan user_id jika poll_id ada di tabel ini)
            // Untuk implementasi ini, kita akan handle di logic untuk memastikan user hanya vote sekali per poll.
            // Jika ingin constraint di DB: $table->unique(['poll_id', 'user_id']); (tapi poll_id harus ditambahkan ke tabel ini)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
    }
};