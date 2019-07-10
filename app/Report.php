<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'order_id',
        'period',
        'report_key',
        'start_date',
        'end_date',
        'tree_height',
        'tree_diameter',
        'tree_state',
        'weather',
        'report_image',
        'report_video'
    ];

    /**
     * get order detail
     * 
     * @return BelongsTo App\Order
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
