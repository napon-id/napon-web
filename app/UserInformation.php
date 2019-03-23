<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $fillable = [
      'user_id',
      'phone',
      'address',
      'ktp',
      'born_place',
      'born_date',
      'gender',
      'city',
      'province',
      'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
