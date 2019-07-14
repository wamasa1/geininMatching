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
    'age' => $faker->numberBetween($min = 15, $max = 40),
    'activity_place' => $faker->randomElement(['東京', '大阪', '福岡', '仙台', '札幌', '沖縄']),
    'genre' => $faker->randomElement(['漫才', 'コント', '両方']),
    'role' => $faker->randomElement(['ボケ', 'ツッコミ', 'こだわらない']),
    'creater' => $faker->randomElement(['自分が作る', '一緒に作りたい', '相方に作ってほしい']),
    'target' => $faker->randomElement(['ゴールデンで冠番組を持つ', '深夜で面白い番組がしたい', 'テレビより舞台で活躍したい']),
    'monomane' => $faker->randomElement(['ビートたけしさん', 'さんまさん', '和田アキ子さん', '坂東英二さん', '特になし']),
    'favorite_geinin' => $faker->randomElement(['ダウンタウンさん', 'ナイナイさん', 'くりーむしちゅーさん', '千鳥さん', 'バナナマンさん', '特になし']),
    'favorite_neta' => $faker->randomElement(['チュートリアルさんのちりんちりん漫才', 'パーフェクトヒューマン',  '千鳥さんの癖がスゴイ']),
    'favorite_tv_program' => $faker->randomElement(['水曜日のダウンタウン', 'アメトーク', 'ロンドンハーツ', 'ガキ使']),
    'laughing_event' => $faker->realText(10),
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
    'sender_id' => $faker->numberBetween($min = 11, $max = 80),
    'receiver_id' => $faker->numberBetween($min = 1, $max = 2),
    'message' => $faker->realText(10),
    'readed' => 0,
    'created_at' => now(),
    'updated_at' => now()
  ];
});

$factory->define(Favorite::class, function (Faker $faker) {
  return [
    'favoriteFrom_id' => $faker->numberBetween($min = 1, $max = 15),
    'favoriteTo_id' => $faker->numberBetween($min = 16, $max = 80),
    'created_at' => now(),
    'updated_at' => now()
  ];
});
