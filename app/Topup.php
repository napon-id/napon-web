<?php

namespace App;
use Event;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'amount',
        'status'
    ];

    /**
     * get user belongs to topup data
     * 
     * @return BelongsTo App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function ($topup) {
            Event::fire('topup.updating', $topup);
        });
    }
}
