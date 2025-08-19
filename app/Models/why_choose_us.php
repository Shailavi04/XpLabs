<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class why_choose_us extends Model
{


    use HasFactory;

     protected $table = 'why_choose_uses';

    protected $fillable = [
        'main_image',
        'icon',
        'title',
        'description',
        'list_items',
    ];

    protected $casts = [
        'list_items' => 'array',
    ];
}
