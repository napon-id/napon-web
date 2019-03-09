<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'country' => $faker->name,
        'location' => $faker->name,
        'address' => $faker->name,
    ];
});
