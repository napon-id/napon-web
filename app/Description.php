<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    /**
     * @param $fillable
     */
    protected $fillable = [
        'img',
        'title',
        'text'
    ];
}
