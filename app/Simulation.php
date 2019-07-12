<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    protected $fillable = [
        'year',
        'min',
        'max'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
