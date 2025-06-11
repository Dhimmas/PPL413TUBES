<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalProgress extends Model
{
    use HasFactory;

    protected $fillable = ['study_goal_id', 'date', 'status'];

    // Relasi dengan StudyGoal
    public function studyGoal()
    {
        return $this->belongsTo(StudyGoal::class);
    }
}