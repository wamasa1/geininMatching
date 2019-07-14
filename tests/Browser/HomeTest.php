<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends DuskTestCase
{
        /**
         * A Dusk test example.
         *
         * @return void
         */
        public function testExample()
        {
                $this->browse(function (Browser $browser) {
                        $browser->visit('/')
                                ->assertSee('相方マッチングサイト')
                                ->assertSee('人気芸人ランキング');
                        //ログイン前
                        $browser->visit('/')
                                ->clickLink('相方マッチングサイト')
                                ->assertPathIs('/');

                        $browser->visit('/')
                                ->clickLink('ログイン')
                                ->assertPathIs('/login');

                        $browser->visit('/')
                                ->clickLink('検索')
                                ->assertPathIs('/search');

                        $browser->visit('/')
                                ->clickLink('相性の良い相方')
                                ->assertPathIs('/login');

                        $browser->visit('/')
                                ->clickLink('イベント')
                                ->assertPathIs('/event');

                        $browser->visit('/')
                                ->clickLink('プロフィール')
                                ->assertPathIs('/login');

                        $browser->visit('/')
                                ->clickLink('お気に入り')
                                ->assertPathIs('/login');

                        $browser->visit('/')
                                ->clickLink('メッセージ')
                                ->assertPathIs('/login');

                        $browser->visit('/')
                                ->clickLink('登録情報')
                                ->assertPathIs('/login');
                });
        }
}
