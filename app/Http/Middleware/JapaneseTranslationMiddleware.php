<?php

namespace App\Http\Middleware;

use Closure;

class JapaneseTranslationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$request->activity_placeを和訳
        $activity_place_En = $request->activity_place;
        $activity_place_Ja = null;
        if ($activity_place_En != null) {
            for ($i = 0; $i < count($activity_place_En); $i++) {
                switch ($activity_place_En[$i]) {
                    case 'tokyo':
                        $activity_place_Ja[$i] = '東京';
                        break;
                    case 'osaka':
                        $activity_place_Ja[$i] = '大阪';
                        break;
                    case 'fukuoka':
                        $activity_place_Ja[$i] = '福岡';
                        break;
                    case 'sendai':
                        $activity_place_Ja[$i] = '仙台';
                        break;
                    case 'sapporo':
                        $activity_place_Ja[$i] = '札幌';
                        break;
                    case 'okinawa':
                        $activity_place_Ja[$i] = '沖縄';
                        break;
                }
            }
        }
        //$request->genreを和訳
        $genre_En = $request->genre;
        $genre_Ja = null;
        if ($genre_En != null) {
            for ($i = 0; $i < count($genre_En); $i++) {
                switch ($genre_En[$i]) {
                    case 'manzai':
                        $genre_Ja[$i] = '漫才';
                        break;
                    case 'konto':
                        $genre_Ja[$i] = 'コント';
                        break;
                    case 'both':
                        $genre_Ja[$i] = '両方';
                        break;
                }
            }
        }
        //$request->roleを和訳
        $role_En = $request->role;
        $role_Ja = null;
        if ($role_En != null) {
            for ($i = 0; $i < count($role_En); $i++) {
                switch ($role_En[$i]) {
                    case 'boke':
                        $role_Ja[$i] = 'ボケ';
                        break;
                    case 'tukkomi':
                        $role_Ja[$i] = 'ツッコミ';
                        break;
                    case 'boke_tukkomi':
                        $role_Ja[$i] = 'こだわらない';
                        break;
                }
            }
        }
        //$request->createrを和訳
        $creater_En = $request->creater;
        $creater_Ja = null;
        if ($creater_En != null) {
            for ($i = 0; $i < count($creater_En); $i++) {
                switch ($creater_En[$i]) {
                    case 'me':
                        $creater_Ja[$i] = '自分が作る';
                        break;
                    case 'together':
                        $creater_Ja[$i] = '一緒に作りたい';
                        break;
                    case 'you':
                        $creater_Ja[$i] = '相方に作ってほしい';
                        break;
                }
            }
        }
        //$request->targetを和訳
        $target_En = $request->target;
        $target_Ja = null;
        if ($target_En != null) {
            for ($i = 0; $i < count($target_En); $i++) {
                switch ($target_En[$i]) {
                    case 'golden':
                        $target_Ja[$i] = 'ゴールデンで冠番組を持つ';
                        break;
                    case 'midnight':
                        $target_Ja[$i] = '深夜で面白い番組がしたい';
                        break;
                    case 'theater':
                        $target_Ja[$i] = 'テレビより舞台で活躍したい';
                        break;
                }
            }
        }
        
        $merge_data = [
            'activity_place_Ja' => $activity_place_Ja,
            'genre_Ja' => $genre_Ja,
            'role_Ja' => $role_Ja,
            'creater_Ja' => $creater_Ja,
            'target_Ja' => $target_Ja,
        ];
        $request->merge($merge_data);

        return $next($request);
    }
}
