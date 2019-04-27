<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    /**
     * @param static
     */
    const MALE = 1;
    const FEMALE = 2;

    /**
     * @param $fillable
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
		'ktp',
		'born_place',
		'born_date',
		'gender',
		'city',
		'province',
		'postal_code',
	];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
