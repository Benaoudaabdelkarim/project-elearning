<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Slide;
use Faker\Generator as Faker;

$factory->define(Slide::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(rand(5,10)),
        'body' => $faker->paragraph(rand(20,50)),
    ];
});
