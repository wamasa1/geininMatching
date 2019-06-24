<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Geinin;
use App\Message;
use App\Favorite;
use Faker\Generator as Faker;

$factory->define(Geinin::class, function (Faker $faker) {
    return [
      'user' => $faker->name,
      'image' => null,
      'genre' => $faker->randomElement(['漫才','コント','両方']),
      'role' => $faker->randomElement(['ボケ','ツッコミ','こだわらない']),
      'creater' => $faker->randomElement(['自分が作る','一緒に作りたい','相方に作ってほしい']),
      'target' => $faker->randomElement(['ゴールデンで冠番組を持つ','深夜で面白い番組がしたい','テレビより舞台で活躍したい']),
      'self_introduce' => $faker->realText(20),
      'email' => $faker->safeEmail,
      'password' => $faker->password,
      'favorite_count' => 0,
      'created_at' => now(),
      'updated_at' => now()
    ];
});

$factory->define(Message::class, function (Faker $faker) {
    return [
      'sender_id' => $faker->numberBetween($min = 16, $max = 30),
      'receiver_id' => $faker->numberBetween($min = 1, $max = 15),
      'message' => $faker->realText(10),
      'created_at' => now(),
      'updated_at' => now()
    ];
});

$factory->define(Favorite::class, function (Faker $faker) {
    return [
      'favoriteFrom_id' => $faker->numberBetween($min = 1, $max = 15),
      'favoriteTo_id' => $faker->numberBetween($min = 16, $max = 30),
      'created_at' => now(),
      'updated_at' => now()
    ];
});
