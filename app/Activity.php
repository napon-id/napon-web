<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'activity_id',
        'activity_type',
        'content',
        'status'
    ];
}
