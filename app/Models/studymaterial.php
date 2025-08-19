<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studymaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'course_id',
        'batch_id',
        'type',
        'description',
        'status',
        'created_by',
        'value'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
