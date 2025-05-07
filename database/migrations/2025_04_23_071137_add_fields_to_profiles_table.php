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
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'profile_picture')) {
                $table->string('profile_picture')->nullable();
            }
        });
    }
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['tanggal_lahir', 'gender', 'phone', 'bio', 'profile_picture']);
        });
    }
};
