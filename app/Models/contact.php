<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use HasFactory;

     protected $fillable = [
        'title',
        'heading',
        'decription',
        'address',
        'phone',
        'email_address',
    ];
}

