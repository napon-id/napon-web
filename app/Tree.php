<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $fillable = [
      'name', 'description', 'available'
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
