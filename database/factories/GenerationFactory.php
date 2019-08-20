<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Generation;
use Faker\Generator as Faker;

    $factory->define(Generation::class, function (Faker $faker) {
        return [
            'type' => Generation::TYPE_STRING,
            'result' => str_random(16),
        ];
    });
