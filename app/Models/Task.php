<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 
        'date', 'time', 'completed'
    ];
    
    // Casting tipe data
    protected $casts = [
        'date' => 'date', // Auto-convert ke Carbon
        'time' => 'datetime:H:i',
        'completed' => 'boolean', // Convert ke true/false
    ];
    
    // Relasi ke kategori (1 Task punya 1 Kategori)
    public function category()
    {
        return $this->belongsTo(TaskCategory::class);
    }
}
