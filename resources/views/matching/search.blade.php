@extends('layouts.matching')

@section('title', '検索画面')

@section('header')
<!-- 認証時はログアウトボタン それ以外の時はログインボタン -->
  @if ($auth)
    @include('shared.logout_button')
  @else
    @include('shared.login_button')
  @endif

  <h1 id="title-font" class="text-secondary">検索画面</h1>
@endsection

@section('body')
  <!-- メッセージ送信完了メッセージ -->
  @include('shared.flash_message', ['message' => 'message_success'])
  <!-- お気に入り登録完了メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_success'])
  <!-- お気に入り登録解除メッセージ -->
  @include('shared.flash_message', ['message' => 'favorite_delete'])

  <!-- おみくじ検索 -->
  <div class="mx-auto my-1 border border-primary">
    <form action="{{ url('/search') }}" method="get">
      {{ csrf_field() }}
      <strong>完全ランダムで１人表示！その芸人が運命の相方かも！　</strong>
      <button type="submit" name="omikuji" value="true" class="my-1 btn btn-primary" style="cursor: pointer">
        おみくじ検索
      </button>
    </form>
  </div>

  <!-- 詳細検索 -->
  <form action="{{ url('/search') }}" method="get">
    {{ csrf_field() }}
    <div class="mx-auto mb-3 border border-primary">
      <!-- 活動場所 -->
      <fieldset>
        <h5 class="font-weight-bold" style="background-color: whitesmoke;">活動場所<small>（複数選択可）</small></h5>
        <div class="form-check form-check-inline ml-3">
          <input class="form-check-input" type="checkbox" id="tokyo" name="activity_place[]" value="tokyo" @if (is_array($activity_place) && in_array("tokyo", $activity_place)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="tokyo">東京</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="osaka" name="activity_place[]" value="osaka" @if (is_array($activity_place) && in_array("osaka", $activity_place)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="osaka">大阪</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="fukuoka" name="activity_place[]" value="fukuoka" @if (is_array($activity_place) && in_array("fukuoka", $activity_place)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="fukuoka">福岡</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="sendai" name="activity_place[]" value="sendai" @if (is_array($activity_place) && in_array("sendai", $activity_place)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="sendai">仙台</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="sapporo" name="activity_place[]" value="sapporo" @if (is_array($activity_place) && in_array("sapporo", $activity_place)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="sapporo">札幌</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="okinawa" name="activity_place[]" value="okinawa" @if (is_array($activity_place) && in_array("okinawa", $activity_place)) checked @endif>
          <label class="form-check-label pl-0 pr-2" for="okinawa">沖縄</label>
        </div>
      </fieldset>
      <!-- 希望するジャンル -->
      <fieldset class="mt-1">
        <h5 class="font-weight-bold" style="background-color: whitesmoke;">希望するジャンル<small>（複数選択可）</small></h5>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="manzai" name="genre[]" value="manzai" @if (is_array($genre) && in_array("manzai", $genre)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="manzai">漫才</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="konto" name="genre[]" value="konto" @if (is_array($genre) && in_array("konto", $genre)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="konto">コント</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="both" name="genre[]" value="both" @if (is_array($genre) && in_array("both", $genre)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="both">両方</label>
        </div>
      </fieldset>
      <!-- 役割 -->
      <fieldset class="mt-1">
      <h5 class="font-weight-bold" style="background-color: whitesmoke;">役割<small>（複数選択可）</small></h5>
      <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="boke" name="role[]" value="boke" @if (is_array($role) && in_array("boke", $role)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="boke">ボケ</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="tukkomi" name="role[]" value="tukkomi" @if (is_array($role) && in_array("tukkomi", $role)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="tukkomi">ツッコミ</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="boke_tukkomi" name="role[]" value="boke_tukkomi" @if (is_array($role) && in_array("boke_tukkomi", $role)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="boke_tukkomi">こだわらない</label>
        </div>
      </fieldset>
      <!-- ネタ作り -->
      <fieldset class="mt-1">
        <h5 class="font-weight-bold" style="background-color: whitesmoke;">ネタ作り<small>（複数選択可）</small></h5>
        <div class="form-check form-check-inline ml-2">
          <input class="form-check-input" type="checkbox" id="me" name="creater[]" value="me" @if (is_array($creater) && in_array("me", $creater)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="me">自分が作る</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="together" name="creater[]" value="together" @if (is_array($creater) && in_array("together", $creater)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="together">一緒に作りたい</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="you" name="creater[]" value="you" @if (is_array($creater) && in_array("you", $creater)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="you">相方に作ってほしい</label>
        </div>
      </fieldset>
      <!-- 目標 -->
      <fieldset class="mt-1">
      <h5 class="font-weight-bold" style="background-color: whitesmoke;">目標<small>（複数選択可）</small></h5>
        <div class="form-check form-check-inline ml-3">
          <input class="form-check-input" type="checkbox" id="golden" name="target[]" value="golden" @if (is_array($target) && in_array("golden", $target)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="golden">ゴールデンで冠番組を持つ</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="midnight" name="target[]" value="midnight" @if (is_array($target) && in_array("midnight", $target)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="midnight">深夜で面白い番組がしたい</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="theater" name="target[]" value="theater" @if (is_array($target) && in_array("theater", $target)) checked @endif>
          <label class="form-check-label pl-0 pr-3" for="theater">テレビより舞台で活躍したい</label>
        </div>
      </fieldset>
      <!-- その他 -->
      <fieldset class="mt-1">
      <h5 class="font-weight-bold" style="background-color: whitesmoke;">その他<small></small></h5>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="imageUpload" name="imageUpload" value="true" {{ $imageUpload == 'true' ? 'checked' : '' }}>
          <label class="form-check-label pl-0 pr-3" for="imageUpload">画像がある</label>
        </div>
      </fieldset>
      <!-- ログインユーザー限定項目 -->
      <fieldset class="mt-1">
        <h5 class="font-weight-bold" style="background-color: whitesmoke;">ログインユーザー限定項目<small></small></h5>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="threeAge" name="threeAge" value="true" {{ $threeAge == 'true' ? 'checked' : '' }}>
          <label class="form-check-label pl-0 pr-3" for="threeAge">自分の年齢±３才</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="exceptFavorite" name="exceptFavorite" value="true" {{ $exceptFavorite == 'true' ? 'checked' : '' }}>
          <label class="form-check-label pl-0 pr-3" for="exceptFavorite">お気に入り登録済み芸人除く</label>
        </div>
      </fieldset>
      <!-- キーワード -->
      <fieldset class="my-1" style="background-color: whitesmoke;">
        <input class="py-1" size="30" type="search" name="keyword" value="{{ $keyword }}" placeholder="キーワードを入力" autocomplete="on" list="keywords">
        <datalist id="keywords">
          <option value="テスト">
          <option value="ナイナイ ボケ">
          <option value="ダウンタウン　ガキ使">
        </datalist>
      </fieldset>
      <button type="submit" class="col-6 my-1 btn btn-primary" style="cursor: pointer">検索</button>
    </div>
    <!-- 検索した条件表示 -->
    <div class="float-left">
      <small class="text-left font-italic font-weight-light">
        @if ($omikuji)
          \おみくじ検索
        @endif
        @include('shared.search_condition', ['search_condition' => $activity_place_Ja])
        @include('shared.search_condition', ['search_condition' => $genreJa])
        @include('shared.search_condition', ['search_condition' => $roleJa])
        @include('shared.search_condition', ['search_condition' => $createrJa])
        @include('shared.search_condition', ['search_condition' => $targetJa])
        @if ($imageUpload)
          \画像がある
        @endif
        @if ($auth && $threeAge)
          \自分の年齢±３才
        @endif
        @if ($auth && $exceptFavorite)
          \お気に入り登録済み芸人除く
        @endif
        @if ($keyword != null)
          \{{ $keyword }}
        @endif
        @if ($order != null)
          @switch ($order)
            @case ('orderFavorite')
              \人気順
            @break;
            @case ('orderRegister')
              \新規登録順
            @break;
            @case ('orderYoung')
              \年齢が若い順
            @break;
            @case ('orderRandom')
              \ランダム順
            @break;
          @endswitch
        @endif
      </small>
    </div>
    <!-- 並び順 -->
    <fieldset class="text-right">
      <select name="order" onChange="this.form.submit()">
        <option value="orderFavorite" {{ $order == 'orderFavorite' ? 'selected' : '' }}>人気順</option>
        <option value="orderRegister" {{ $order == 'orderRegister' ? 'selected' : '' }}>新規登録順</option>
        <option value="orderYoung" {{ $order == 'orderYoung' ? 'selected' : '' }}>年齢が若い順</option>
        <option value="orderRandom" {{ $order == 'orderRandom' ? 'selected' : '' }}>ランダム順</option>
      </select>
    </fieldset>
  </form>

  <div class="my-2">
    <mark class="font-weight-bold">現在、全{{ $allCount }}件中{{ $hitCount }}件がヒット！</mark>
  </div>

  <!-- ログインユーザー限定項目に関するメッセージ -->
  <p class="text-danger my-1">{{ $noAgeMessage }}</p>
  <p class="text-danger">{{ $guestMessage }}</p>
  <!-- 芸人一覧 -->
  <div class="row">
    @if($geinins)
      @foreach($geinins as $geinin)
        <div class="col col-md-6 border border-primary rounded-top" style="background-color: whitesmoke;">
          <!-- プロフィール画像・芸人テーブル・メッセージ送信 -->
          @include('shared.geinin_table')
          <!-- お気に入り芸人登録・解除ボタン -->
          @include('shared.favorite_button', ['url' => 'search'])
        </div>
        @if($loop->iteration == 2)
  </div>
  <div class="row">
        @endif
      @endforeach
      </div>
      <!-- ページネーションリンク  -->
      @if(!$omikuji)
        {{ $geinins->appends([
          'activity_place' => $activity_place, 
          'genre' => $genre, 
          'role' => $role, 
          'creater' => $creater, 
          'target' => $target, 
          'imageUpload' => $imageUpload, 
          'threeAge' => $threeAge, 
          'exceptFavorite' => $exceptFavorite, 
          'keyword' => $keyword, 
          'order' => $order
          ])->onEachSide(1)->links() }}
      @endif

    @endif
@endsection