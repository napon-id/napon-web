<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'queue',
        'payment_number'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
