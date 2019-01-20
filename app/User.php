<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userInformation()
    {
        return $this->hasOne('App\UserInformation');
    }

    public function balance()
    {
        return $this->hasOne('App\Balance');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account');
    }

    public function withdraw()
    {
        return $this->hasMany('App\Withdraw');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
