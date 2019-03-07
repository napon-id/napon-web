<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $fillable = [
      'name', 'description', 'available', 'price'
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
