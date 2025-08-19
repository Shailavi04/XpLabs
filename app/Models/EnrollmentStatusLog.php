<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentStatusLog extends Model
{
    use HasFactory;

    protected $fillable = ['enrollment_id', 'status', 'changed_at'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public $timestamps = true;

    protected $casts = [
    'latest_completed' => 'datetime',
    'latest_dropped' => 'datetime',
];

}
