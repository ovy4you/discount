<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Discount::class, function (Faker $faker) {
    return [
        'discount_type' => 1,
        'discount_rules' => '[{"discount_amount": 10, "minimum_order_amount": 1000}]',
        'active' => 1,
    ];
});
