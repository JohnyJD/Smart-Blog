<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'slug' => $faker->word,
        'text' => $faker->text,
        'slug_image' => "slug_images/img",
        'user_id' => factory(User::class)
    ];
});
