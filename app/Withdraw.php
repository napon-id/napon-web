<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class Withdraw extends Model
{
    protected $fillable = [
      'user_id', 
      'token',
      'account_id', 
      'status', 
      'amount', 
      'information'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($withdraw) {
            Event::fire('withdraw.created', $withdraw);
        });

        static::updated(function ($withdraw) {
            Event::fire('withdraw.updated', $withdraw);
        });
    }
}
