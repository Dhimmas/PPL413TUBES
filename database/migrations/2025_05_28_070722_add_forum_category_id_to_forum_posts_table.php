<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            // Tambahkan kolom forum_category_id setelah kolom tertentu (misalnya 'user_id' atau 'title')
            // Sesuaikan 'after_column_name' dengan nama kolom yang ada di tabel forum_posts Anda
            $table->foreignId('forum_category_id')
                  ->nullable() // Kategori bisa jadi opsional untuk sebuah post
                  ->after('user_id') // Contoh: letakkan setelah kolom user_id. Sesuaikan!
                  ->constrained('forum_categories') // Membuat foreign key constraint ke tabel forum_categories
                  ->onDelete('set null'); // Jika kategori dihapus, set forum_category_id di post menjadi NULL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['forum_category_id']);
            // Kemudian hapus kolomnya
            $table->dropColumn('forum_category_id');
        });
    }
};