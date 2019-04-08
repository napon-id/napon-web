<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cities;

class Province extends Model
{
    protected $fillable = [
        'id',
        'name'
    ];

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}
