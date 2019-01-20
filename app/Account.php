<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
      'user_id', 'name', 'holder_name', 'number', 'account_code'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
