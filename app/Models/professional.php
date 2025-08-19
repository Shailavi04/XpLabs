<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class professional extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','button','button_url'];
}
