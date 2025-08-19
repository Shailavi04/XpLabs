<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Center;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone_number',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function class()
    // {
    //     return $this->hasOne(Classes::class, 'user_id');
    // }

    // public function centers()
    // {
    //     return $this->hasOne(Center::class);
    // }



    public function students_instructor()
    {
        return $this->hasMany(students_instructor::class, 'user_id');
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    public static function isAdmin()
    {
        $user = auth()->user();
        return $user && $user->role_id == 1;
    }

    public static function isCenterManager()
    {
        $user = auth()->user();
        return $user && $user->role_id == 2;
    }

    public function centers()
    {
        return $this->belongsToMany(Center::class, 'center_user', 'user_id', 'center_id');
    }
}
