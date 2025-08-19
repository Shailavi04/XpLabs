<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id',
        'instructor_id',
        'start_date',
        'end_date',
        'schedule',
        'status'
    ];



    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // In app/Models/Batch.php

    public function getScheduleAttribute($value)
    {
        // If it's already an array, return it
        if (is_array($value)) {
            return $value;
        }

        // Else, explode string by comma or return empty array
        return $value ? explode(',', $value) : [];
    }

    // Mutator for schedule (optional, if you want to save array as string)
    public function setScheduleAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['schedule'] = implode(',', $value);
        } else {
            $this->attributes['schedule'] = $value;
        }
    }


    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'batch_id');
    }

    
}
