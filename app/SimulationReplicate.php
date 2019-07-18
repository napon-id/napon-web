<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulationReplicate extends Model
{
    protected $fillable = [
        'product_id',
        'year',
        'min',
        'max'
    ];

    public function product()
    {
        return $this->belongsTo('App\ProductReplicate');
    }
}
