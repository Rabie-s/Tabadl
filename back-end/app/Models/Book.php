<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'book_level',
        'image_path',
        'status',
        'description',
        'active',
        'done',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //format date
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d');
    }
}
