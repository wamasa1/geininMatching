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
            $activity_place = str_replace('tokyo', '東京', $activity_place_En);
            $activity_place = str_replace('osaka', '大阪', $activity_place);
            $activity_place = str_replace('fukuoka', '福岡', $activity_place);
            $activity_place = str_replace('sendai', '仙台', $activity_place);
            $activity_place = str_replace('sapporo', '札幌', $activity_place);
            $activity_place_Ja = str_replace('okinawa', '沖縄', $activity_place);
        }
        //$request->genreを和訳
        $genre_En = $request->genre;
        $genre_Ja = null;
        if ($genre_En != null) {
            $genre = str_replace('manzai', '漫才', $genre_En);
            $genre = str_replace('konto', 'コント', $genre);
            $genre_Ja = str_replace('both', '両方', $genre);
        }
        //$request->roleを和訳
        $role_En = $request->role;
        $role_Ja = null;
        if ($role_En != null) {
            $role = str_replace('boke', 'ボケ', $role_En);
            $role = str_replace('tukkomi', 'ツッコミ', $role);
            $role_Ja = str_replace('boke_tukkomi', 'こだわらない', $role);
        }
        //$request->createrを和訳
        $creater_En = $request->creater;
        $creater_Ja = null;
        if ($creater_En != null) {
            $creater = str_replace('me', '自分が作る', $creater_En);
            $creater = str_replace('together', '一緒に作りたい', $creater);
            $creater_Ja = str_replace('you', '相方に作ってほしい', $creater);
        }
        //$request->targetを和訳
        $target_En = $request->target;
        $target_Ja = null;
        if ($target_En != null) {
            $target = str_replace('golden', 'ゴールデンで冠番組を持つ', $target_En);
            $target = str_replace('midnight', '深夜で面白い番組がしたい', $target);
            $target_Ja = str_replace('theater', 'テレビより舞台で活躍したい', $target);
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
