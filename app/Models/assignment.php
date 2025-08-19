<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    use HasFactory;


    protected $fillable = [
        'course_id',
        'batch_id',
        'created_by',
        'title',
        'description',
        'attachment',
        'publish_date',
        'due_date',
        'status',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Assignment model
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // AssignmentSubmission model
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
