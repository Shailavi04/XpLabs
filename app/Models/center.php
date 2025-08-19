<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class center extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'state',
        'city',
        'postal_code',
        'description',
        'address',
        'code',
        'longitude',
        'latitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staff()
    {
        return $this->belongsToMany(User::class, 'center_user', 'center_id', 'user_id');
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
