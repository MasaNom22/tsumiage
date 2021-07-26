<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'content' => $faker->sentence,
        'study_hour' => $faker->numberBetween(0,23),
        'study_time' => $faker->numberBetween(0,59),
        'study_date' => $faker->date($format=‘Y-m-d’),
        'user_id' => function () {
            return factory(User::class);
        }
    ];
});
