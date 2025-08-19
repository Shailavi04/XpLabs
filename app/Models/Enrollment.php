<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'enrollment';

    protected $fillable = [
        'student_id',
        'student_icard',
        'center_id',
        'course_id',
        'enrollment_id',
        'token_amount',
        'status',
        'payment_status',
        'remarks',
    ];



    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // Enrollment.php
    public function completedLog()
    {
        return $this->hasOne(EnrollmentStatusLog::class, 'enrollment_id')
            ->where('status', 3)
            ->latestOfMany('changed_at');
    }

    public function droppedLog()
    {
        return $this->hasOne(EnrollmentStatusLog::class, 'enrollment_id')
            ->where('status', 4)
            ->latestOfMany('changed_at');
    }
}
