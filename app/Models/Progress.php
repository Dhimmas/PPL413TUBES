<?php

namespace App\Models;

// app/Models/Progress.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = ['study_goal_id', 'date', 'status'];

    // Relasi ke StudyGoal
    public function studyGoal()
    {
        return $this->belongsTo(StudyGoal::class, 'study_goal_id');
    }
}