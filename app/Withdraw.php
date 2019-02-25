<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
      'user_id', 'account_id', 'status', 'amount',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
