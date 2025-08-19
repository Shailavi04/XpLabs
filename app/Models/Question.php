<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

     protected $fillable = [
        'text',
        'type',                // <-- add type here
        'code_snippet',
        'answer_explanation',
        'more_info_link',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
    public function quizzes()
{
    return $this->belongsToMany(Quiz::class);
}

}
