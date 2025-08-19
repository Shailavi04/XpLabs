<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testimonial_section extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'title',
        'subtitle',
        'type',
        'button_text',
        'button_url',
        'background_image',
    ];

    public function contents()
    {


        return $this->belongsTo(testimonial_content::class, 'testimonial_section_id', 'id');
    }
}
