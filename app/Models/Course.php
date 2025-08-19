<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'duration',
        'description',
        'category_id',
        'status',
        'image',
        'curriculum',
        'total_fee',
        'seats_available',
        'token_amount',
        'center_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('uploads/courses/' . $this->image)
            : asset('default-course.png');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'subscription')
            ->withPivot('token_amount', 'is_confirmed', 'status', 'total_installments', 'installments_paid')
            ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(Student::class, 'enrollment', 'course_id', 'student_id')
            ->wherePivot('status', 2);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

   public function centers()
    {
        return $this->belongsToMany(
            Center::class,
            'center_course',
            'course_id',
            'center_id'  
        );
    }
}
