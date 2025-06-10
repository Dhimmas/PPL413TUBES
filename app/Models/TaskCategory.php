<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $fillable = ['name']; // Kolom yang bisa diisi
    
    // Relasi ke tasks (1 Kategori punya banyak Task)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}