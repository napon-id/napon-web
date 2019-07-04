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
		'born_date',
		'gender',
		'city',
		'province',
        'postal_code',
        'user_image',
        'user_id_image'
	];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Cities', 'city_id');
    }
}
