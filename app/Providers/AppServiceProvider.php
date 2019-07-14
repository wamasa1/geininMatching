<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Favorite;
use App\Message;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  { //herokuでhttpsにするため
    if (\App::environment('production')) {
      \URL::forceScheme('https');
    }
    //全ビューで使う値(お気に入り登録数)
    View::composer('*', function ($view) {
      if (Auth::guard('geinin')->check()) {
        $auth_id = Auth::guard('geinin')->id();
        $favorite_badgeCount = Favorite::where('favoriteFrom_id', $auth_id)->count();
      } else {
        $favorite_badgeCount = 0;
      }

      $view->with('favorite_badgeCount', $favorite_badgeCount);
    });
    //全ビューで使う値(未読メッセージ数)
    View::composer('*', function ($view) {
      if (Auth::guard('geinin')->check()) {
        $auth_id = Auth::guard('geinin')->id();
        $message_badgeCount = Message::where('receiver_id', $auth_id)->where('readed', '<', 2)->count();
      } else {
        $message_badgeCount = 0;
      }

      $view->with('message_badgeCount', $message_badgeCount);
    });
  }
}
