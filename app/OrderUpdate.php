<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderUpdate extends Model
{
    protected $fillable = [
      'order_id', 'description'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
