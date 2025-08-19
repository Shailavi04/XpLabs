<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class frontend_elements extends Model
{
    use HasFactory;

    protected $table = 'frontend_elements'; // optional if name matches convention

    protected $fillable = [
        'section_key',
        'data',
        'order',
    ];

    protected $casts = [
        'data' => 'array', // Automatically cast JSON to array
    ];
}
