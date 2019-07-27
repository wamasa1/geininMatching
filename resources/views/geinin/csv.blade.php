@extends('layouts.geinin')

@section('title', '相方マッチングサイト')

@section('body')
  <form action="{{ url('/csv/download') }}" method="get">
    {{ csrf_field() }}
    <div class="mt-5 pt-5">
      <button class="btn btn-dark btn-lg p-2" style="cursor: pointer;" type="submit" name="csv_download">登録者全員のデータをCSVでダウンロード</button>
    </div>
  </form>
@endsection