<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReplicate extends Model
{
    protected $fillable = [
        'tree_id',
        'name',
        'tree_quantity',
        'description',
        'available',
        'price',
        'img_black',
        'img_white',
        'img_background'
    ];

    public function tree()
    {
        return $this->belongsTo('App\Tree');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function simulations()
    {
        return $this->hasMany('App\SimulationReplicate');
    }
}
