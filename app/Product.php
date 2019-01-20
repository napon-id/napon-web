<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
      'tree_id', 'name', 'tree_quantity', 'description', 'total_price', 'time', 'available'
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
