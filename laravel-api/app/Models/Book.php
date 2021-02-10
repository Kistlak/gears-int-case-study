<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_name',
        'description',
        'price'
    ];

    public function authors()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
