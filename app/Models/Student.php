<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // app/Models/Student.php

    protected $fillable = [
        'center_id',
        'user_id',
        'gender',
        'dob',
        'city',
        'state',
        'country',
        'postal_code',
        'parent_name',
        'parent_contact_number',
        'alternate_contact_number',
        'nationality',
        'education_level',
        'blood_group',
        'bio',
        'status',
        'image',
        'icard'
    ];



    public function course()
    {
        return $this->belongsTo(Course::class, 'course', 'id');
    }

    // Student.php (Model)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }



    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Student.php model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
