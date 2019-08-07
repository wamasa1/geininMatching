<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\FavoriteRegisterClick;
use App\Events\FavoriteDeleteClick;

class EventTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEvent()
    {
        // FavoriteRegisterClickイベントについて
        $favoriteTo_id = 1;
        Event::fake();
        Event::assertNotDispatched(FavoriteRegisterClick::class);
        event(new FavoriteRegisterClick($favoriteTo_id));
        Event::assertDispatched(FavoriteRegisterClick::class);
        // FavoriteRegisterClickのfavoriteTo_idというプロパティに値がセットされているかをチェック
        Event::assertDispatched(FavoriteRegisterClick::class, function($event) use ($favoriteTo_id) {
                return $event->favoriteTo_id = $favoriteTo_id;
            }
        );

        // FavoriteDeleteClickイベントについて
        Event::assertNotDispatched(FavoriteDeleteClick::class);
        event(new FavoriteDeleteClick($favoriteTo_id));
        Event::assertDispatched(FavoriteDeleteClick::class);
        // FavoriteDeleteClickのfavoriteTo_idというプロパティに値がセットされているかをチェック
        Event::assertDispatched(FavoriteDeleteClick::class, function($event) use ($favoriteTo_id) {
                return $event->favoriteTo_id = $favoriteTo_id;
            }
        );
    }
}
