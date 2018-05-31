<?php

use Faker\Generator as Faker;
use Tests\Fixtures\Models\StandardModel\UserIntegration;

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

$factory->define(UserIntegration::class, function (Faker $faker) {
    return [
        'access_token' => str_random(60), // secret
        'refresh_token' => str_random(10),
        'access_token_expires_in' => $faker->numberBetween(1, 10000),
    ];
});
