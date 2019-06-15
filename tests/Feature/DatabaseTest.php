<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
      $geinin = new \App\Geinin;
      $geinin->user = "山田";
      $geinin->genre = "漫才";
      $geinin->role = "ボケ";
      $geinin->creater = "自分が作る";
      $geinin->target = "ゴールデンで冠番組を持つ";
      $geinin->email = "yamada@test.com";
      $geinin->password = \Hash::make('password');
      $geinin->save();

      $readGeinin = \App\Geinin::where('user', '山田')->first();
      $this->assertNotNull($readGeinin);            // データが取得できたかテスト
      $this->assertTrue(\Hash::check('password', $readGeinin->password)); // パスワードが一致しているかテスト

      \App\Geinin::where('email', 'yamada@test.com')->delete(); // テストデータの削除
    }

}
