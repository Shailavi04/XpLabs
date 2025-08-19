<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'name',
        'code',
        'type',
        'no_of_seats',
        'description',
        'meeting_link',
        'meeting_password',
        'active',
        'created_by',
    ];

    // Relationships
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
