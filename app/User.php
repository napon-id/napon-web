<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Event;

class User extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firebase_uid', 'user_key', 'has_created_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * get user information (one to one)
     * 
     * @return HasOne App\UserInformation
     */
    public function userInformation()
    {
        return $this->hasOne('App\UserInformation');
    }

    /**
     * get user balance data
     * 
     * @return HasOne App\Balance
     */
    public function balance()
    {
        return $this->hasOne('App\Balance');
    }

    /**
     * get user bank accounts
     * 
     * @return HasMany App\Account
     */
    public function accounts()
    {
        return $this->hasMany('App\Account');
    }

    /**
     * get user withdrawals
     * 
     * @return HasMany App\Withdraw
     */
    public function withdraw()
    {
        return $this->hasMany('App\Withdraw');
    }

    /**
     * get user orders data
     * 
     * @return HasMany App\Order
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * get user log activities
     * 
     * @return HasMany App\Log
     */
    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    /**
     * get user withdrawals
     * 
     * @return HasMany App\Withdraw
     */
    public function withdraws()
    {
        return $this->hasMany('App\Withdraw');
    }

    /**
     * static function for Event
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
          Event::fire('user.created', $user);
        });
    }
}
