<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    protected $fillable = [
        'report_id',
        'is_video',
        'display_url'
    ];
}
