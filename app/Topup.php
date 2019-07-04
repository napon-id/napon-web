<?php

namespace App;

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
}
