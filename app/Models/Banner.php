<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'type',
        'heading',
        'subheading',
        'description',
        'review_title',
        'rating',
        'review_text',    
        'button_text',
        'button_url',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
