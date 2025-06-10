<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_file',
        'file_type',
        'image',
        'correct_answer',
        'options',
        'question_type',
        'time_limit_per_question'
    ];

    protected $casts = [
        'options' => 'array', // biar bisa langsung pakai array
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
