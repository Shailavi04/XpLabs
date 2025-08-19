<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testimonial_content extends Model
{
    use HasFactory;

    protected $fillable = [
        'testimonial_section_id',
        'title',
        'about',
        'rating',
        'rating_text',
        'name',
        'designation',
        'profile_image',
    ];

    public function section()
    {
        return $this->hasMany(testimonial_section::class, 'testimonial_section_id', 'id');
    }
}
