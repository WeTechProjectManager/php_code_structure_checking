<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\LockableTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use LockableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'company_id',
    //     'name',
    //     'email',
    //     'phone',
    //     'type',
    //     'avatar',
    //     'status',
    //     'storeAccess',
    //     'password',
    // ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'status',
        'storeAccess',
        'password',
        'address',
        'birthDate',
        'gender',
        'marital_status',
        'image',
        'login_status',
        'realFake_status',
        'company_id',
        'otp',
        'forget_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function totalPost()
    {
        return $this->hasMany(Post::class,'user_id','id')->select('id');
    }

    public function getUserBioData(){
       return $this->hasOne(UserBioData::class, 'user_id', 'id');
    }

}
