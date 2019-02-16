<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
      'tree_id', 'name', 'img', 'tree_quantity', 'description', 'time', 'available',
    ];

    public function tree()
    {
        return $this->belongsTo('App\Tree');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
