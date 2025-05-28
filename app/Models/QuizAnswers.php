<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswers extends Model
{
    protected $fillable = [
        'quiz_result_id',
        'question_id',
        'user_answer',
        'is_correct',
    ];

    public function result()
    {
        return $this->belongsTo(UserQuizResult::class, 'quiz_result_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
