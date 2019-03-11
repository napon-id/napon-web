<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
      // 'country',
      'location',
      'address',
      'lat',
      'lng',
      'description',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
