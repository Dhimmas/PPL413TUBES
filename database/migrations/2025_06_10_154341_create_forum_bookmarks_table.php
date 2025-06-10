<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forum_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('forum_post_id')->constrained('forum_posts')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'forum_post_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('forum_bookmarks');
    }
};