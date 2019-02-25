<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
      'user_id', 'balance'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
