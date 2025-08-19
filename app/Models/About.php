<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'heading',
        'sub_heading',
        'description',
        'main_image',
        'cards',
    ]; 
    protected $casts = [
        'cards' => 'array', 
    ];
}
