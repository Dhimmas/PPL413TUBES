<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id', // Tambahkan field yang akan diisi massal
        'time_limit_per_quiz'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function scopeWithQuestions($query)
    {
        return $query->has('questions');
    }
}
