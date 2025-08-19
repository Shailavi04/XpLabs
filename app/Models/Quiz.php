<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'published',
        'public',
        'description',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_quizzes');
    }
    

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_quizzes');
    }
}
