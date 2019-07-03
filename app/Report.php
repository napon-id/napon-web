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
        'roi',
        'report_image',
        'report_video'
    ];
}
