<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Email;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    $subject = $faker->sentence(rand(3,5));
    return [
        'name' => $faker->name,
        'subject' => $subject,
        'slug' => Str::slug($subject),
        'message' => $faker->sentence(rand(5,10)),
        'number' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
    ];
});
