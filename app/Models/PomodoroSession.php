<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PomodoroSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_name',
        'description',
        'type',
        'duration_minutes',
        'started_at',
        'ended_at',
    ];

    protected $dates = ['started_at', 'ended_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

