<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuizResult extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'status',
        'score',
        'started_at',
        'finished_at',
        'ends_at',
        'last_question_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswers::class, 'quiz_result_id');
    }
}