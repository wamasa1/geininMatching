<!-- 相性の良い芸人表示 -->
<p id="title-font" class="mt-5 mb-2">マッチング率{{ $matching_percent }}%</p>
<div class="row">
  @forelse ($partners as $partner)
  <div class="col col-md-6 border border-primary rounded-top" style="background-color: aliceblue;">
    <!-- プロフィール画像・芸人テーブル・メッセージ送信 -->
    @include('shared.geinin_table', ['geinin' => $partner])
    <!-- お気に入り芸人登録・解除ボタン -->
    @include('shared.favorite_button', ['geinin' => $partner, 'url' => 'show'])
  </div>
  @if($loop->iteration % 2 == 0)
</div>
<div class="row">
  @endif
  @break($loop->iteration == 4)

  @empty
  <p class="col">残念ながら、見つかりませんでした</p>
  @endforelse
  </div>
