<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'status',
        'title',
        'subtitle',
        'content'
    ];

    /**
     * retrieve user related to each notification
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
