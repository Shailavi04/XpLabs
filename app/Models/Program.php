<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'duration_weeks', 'mode', 'fee',
        'certificate_enabled', 'certificate_criteria', 'rank_criteria', 'is_active'
    ];

     protected $casts = [
        'certificate_enabled' => 'boolean',
        'rank_criteria' => 'array',
        'is_active' => 'boolean'
    ];
}
