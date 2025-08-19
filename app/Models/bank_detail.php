<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'bank_name',
        'active',
    ];

    // Relationship to User
    public function studentInstructor()
    {
        return $this->belongsTo(students_instructor::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
