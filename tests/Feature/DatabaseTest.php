<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Geinin;

class DatabaseTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function testDatabase()
  {
    $geinin = new Geinin;
    $geinin->user = "山田";
    $geinin->activity_place = "東京";
    $geinin->genre = "漫才";
    $geinin->role = "ボケ";
    $geinin->creater = "自分が作る";
    $geinin->target = "ゴールデンで冠番組を持つ";
    $geinin->email = "yamada@test.com";
    $geinin->password = \Hash::make('password');
    $geinin->favorite_count = 0;
    $geinin->save();

    $readGeinin = Geinin::where('user', '山田')->first();
    $this->assertNotNull($readGeinin);            // データが取得できたかテスト
    $this->assertTrue(\Hash::check('password', $readGeinin->password)); // パスワードが一致しているかテスト

    Geinin::where('email', 'yamada@test.com')->delete(); // テストデータの削除
  }
}
