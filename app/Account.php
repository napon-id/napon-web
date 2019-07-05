<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
      'user_id', 
      'token',
      'name', 
      'holder_name', 
      'number', 
      'account_code'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
