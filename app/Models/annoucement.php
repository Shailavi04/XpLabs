<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class annoucement extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',    // optional link to a classroom
        'created_by',      // user who created
        'title',
        'message',
        'recipient',
        'active',
    ];

    /**
     * The classroom this announcement is linked to (optional).
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * The user who created the announcement.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope active announcements.
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Helper: get recipient roles as array
     */
    
}
