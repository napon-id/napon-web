<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class Order extends Model
{
    protected $fillable = [
      'user_id', 'product_id', 'location_id', 'quantity', 'ip_address', 'status', 'tree_status'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function updates()
    {
        return $this->hasMany('App\OrderUpdate');
    }

    public function location()
    {
        return $this->hasOne('App\Location');
    }

    public function transaction()
    {
        return $this->hasOne('App\Transaction');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($order) {
          Event::fire('order.created', $order);
        });
    }
}
