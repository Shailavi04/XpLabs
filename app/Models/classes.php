<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classes extends Model
{
    use HasFactory;


    protected $table = 'centers';

  protected $fillable = [
    'name',
    'email',
    'phone_number',
    'password',
    'description',
    'code',    // or 'code' if you want
    'created_by',
    'profile_image',
    'active',
    'country',
    'state',
    'city',
    'postal_code',
    'address',
    'longitude',
    'latitude',
    'website',
];


    protected $hidden = [
        'password',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
