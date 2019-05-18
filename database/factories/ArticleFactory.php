<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'img' => 'https://media.napon.id/forest.png',
        'description' => $faker->paragraph,
        'statistic' => rand(0,1000000),
        'author' => $faker->name
    ];
});
