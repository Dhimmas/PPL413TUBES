<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    // Pastikan table name benar (jika berbeda dari default)
    protected $table = 'conversations';

    // Isi kolom yang dapat diisi (fillable)
    protected $fillable = [
        'user_input',
        'bot_response',];
}