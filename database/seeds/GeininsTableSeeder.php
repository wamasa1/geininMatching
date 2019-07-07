<?php

use Illuminate\Database\Seeder;
use App\Geinin;
use Illuminate\Support\Facades\Hash;

class GeininsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // テストユーザー1
      DB::table('geinins')->insert([
          "user" => "松本紳助（テスト）",
          'image' => null,
          "genre" => "漫才",
          "role" => "ボケ",
          "creater" => "自分が作る",
          "target" => "ゴールデンで冠番組を持つ",
          "self_introduce" => "テストです",
          "email" => "ikuta@gmail.com",
          "password" => Hash::make("ikuta"),
          "favorite_count" => 0,
          "created_at" => new DateTime(),
          "updated_at" => new DateTime()
      ]);
      //テストユーザー２
      DB::table('geinins')->insert([
          "user" => "佐藤（テスト）",
          'image' => null,
          "genre" => "漫才",
          "role" => "ツッコミ",
          "creater" => "相方に作ってほしい",
          "target" => "ゴールデンで冠番組を持つ",
          "self_introduce" => "テストです",
          "email" => "sato@gmail.com",
          "password" => Hash::make("sato"),
          "favorite_count" => 0,
          "created_at" => new DateTime(),
          "updated_at" => new DateTime()
      ]);

      factory(Geinin::class, 60)->create();  
    }
}
