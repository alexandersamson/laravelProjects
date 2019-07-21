<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Casenote;
use Faker\Generator as Faker;

$factory->define(Casenote::class, function (Faker $faker) {
    $creator = rand(1,4);
    return [
        'name' => $faker->text(rand(16,32)),
        'body' => $faker->text(rand(250,1000)),
        'creator_id' => $creator,
        'modifier_id' => $creator,
    ];
});
