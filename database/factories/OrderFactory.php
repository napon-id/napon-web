<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    // get all user id for foreign key
    $users_id = \App\User::all()->pluck('id')->toArray();

    // get all product id for foreign key
    $products_id = \App\Product::all()->pluck('id')->toArray();

    // set order status
    $statuses = ['waiting', 'paid'];
    
    return [
        'user_id' => $faker->randomElement($users_id),
        'product_id' => $faker->randomElement($products_id),
        'status' => $faker->randomElement($statuses),
    ];
});
