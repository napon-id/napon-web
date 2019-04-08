<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Province;

class Cities extends Model
{
    protected $fillable = [
        'id',
        'province_id',
        'name'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
