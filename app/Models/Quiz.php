<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id' // Tambahkan field yang akan diisi massal
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
