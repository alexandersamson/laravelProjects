<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'bitwise-value' => 0,
        'name' => 'Nothing',
        'description' => 'No permissions'
    ];
});


