<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscription';

    protected $fillable = [
        'student_id',
        'course_id',
        'token_amount',
        'is_confirmed',
        'status',
        'total_installments',
        'installments_paid',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

  
    public function transactions()
    {
        return $this->hasMany(transactions::class);
    }
}
