<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class joincommunity extends Model
{
    use HasFactory;

    protected $fillable = ['background_image','title','description','card'];
}
