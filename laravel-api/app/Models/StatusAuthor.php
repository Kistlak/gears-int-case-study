<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status'
    ];
}
