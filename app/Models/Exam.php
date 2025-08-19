<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'exam_date',
        'duration',
        'mode',
        'location',
        'online_link',
        'batch_id',
        'passing_marks',
        'correct_answer_mark',
        'incorrect_answer_mark',
        'instructions',
        'status' // if you have a status column
    ];

    // Relationships
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
