<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Event;

class Order extends Model
{
    protected $fillable = [
      'user_id',
      'token',
      'product_id',
      'location_id',
      'ip_address',
      'status',
      'selling_price',
      'certificate',
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
        return $this->belongsTo('App\Location');
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

        static::updated(function ($order) {
            Event::fire('order.updated', $order);
        });

        static::updating(function ($order) {
            Event::fire('order.updating', $order);
        });
    }
}
