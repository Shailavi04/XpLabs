<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // public function transactions()
    // {
    //     return $this->hasMany(Transactions::class);
    // }

    
}
