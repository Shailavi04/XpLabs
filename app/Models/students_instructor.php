<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students_instructor extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'emergency_contact',
        'center_id',
        'password',
        'qualification',
        'designation',
        'experience_years',
        'joining_date',
        'bio',
        'profile_image',
        'active'
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
