<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyGoal extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'status'];

    // Relationship to progress
    public function progress()
    {
        return $this->hasMany(GoalProgress::class);
    }
}