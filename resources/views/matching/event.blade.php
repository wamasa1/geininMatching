@extends('layouts.matching')

@section('title', 'イベント')

@section('header')
  <!-- 認証時はログアウトボタン それ以外の時はログインボタン -->
  @if ($auth)
  <div class="text-right mt-1">
    <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
    </a>
  </div>
  @else
  <div class="text-right mt-1">
    <a class="btn btn-primary" href="{{ url('/login') }}" role="button">
      ログイン
    </a>
  </div>
  @endif

  <h1 id="title-font" class="text-info display-3 pt-2 mt-2 mb-5">イベント</h1>
@endsection

@section('body')
  <h2 id="title-font-size">気になる芸人さんを誘って参加してみませんか？</h2>
  <div id="event" class="row my-5 bg-light">
    <div class="col text-center mb-3">
      <h3>NSC東京</h3>
      <p>NSC学院説明会</p>
      <p>2019年6/30（日)13:30</p>
      <a href="http://www.yoshimoto.co.jp/nsc/school_tokyo.html#contents06">ホームページ</a>
    </div>
    <div id="nsc_map" class="col"></div>
  </div>
  <div id="event" class="row my-5 bg-light">
    <div class="col text-center mb-3">
      <h3>ワタナベコメディスクール</h3>
      <p>素人オーディション</p>
      <p>2019年6/15（土）13：00<br>
         2019年6/16（日）13：00<br>
         2019年6/23（日）13：00<br>
         2019年6/27（木）13：00<br>
         2019年6/30（日）13：00<br>
      </p>
      <a href="http://www.we-school.net/wcs/audition/doshiroto/">ホームページ</a>
    </div>
    <div id="watanabe_map" class="col"></div>
  </div>
@endsection

@section('GoogleMap')
<!-- Google Map API関連（jQuery,js等） -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxbeYuC7fA8pnAHbvOlxeAlZScWYYmCxE"></script>
<script type="text/javascript">
  //NSC東京
  var center1 = {
    lat: 35.695036, // 緯度
    lng: 139.760981 // 経度
  };
  var nsc_map = new google.maps.Map(document.getElementById('nsc_map'), {
    center: center1,
    zoom: 16 //地図のズームを設定
  });
  var marker = new google.maps.Marker({
    position: center1, // マーカーを立てる位置を指定
    map: nsc_map // マーカーを立てる地図を指定
  });

  //ワタナベコメディスクール
  var center2 = {
    lat: 35.647305,
    lng: 139.694671
  };
  var watanabe_map = new google.maps.Map(document.getElementById('watanabe_map'), {
    center: center2,
    zoom: 16
  });
  var marker = new google.maps.Marker({
    position: center2,
    map: watanabe_map
  });
</script>
@endsection
