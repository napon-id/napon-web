<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    $title = $faker->text();

    return [
        'title' => $title,
        'slug' => str_slug($title . '-' . str_random(8)),
        'img' => 'https://media.napon.id/forest.png',
        'description' => $faker->paragraph(10),
        'statistic' => rand(0,1000000),
        'author' => $faker->name
    ];
});
