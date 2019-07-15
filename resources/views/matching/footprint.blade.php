@extends('layouts.matching')

@section('title', 'あしあと')

@section('header')
<div class="text-right mt-1">
   <a class="btn btn-primary" href="{{ url('/logout') }}" role="button">
      ログアウト
   </a>
</div>
<h1 id="title-font" class="display-3 pt-2 mt-2 mb-5" style="color: yellowgreen;">あしあと</h1>
@endsection

@section('body')
<p>あなたのプロフィール詳細画面を見た芸人</p>
<table class="table table-striped table-borderless mt-1">
   <thead style="color: yellowgreen;">
      <tr>
         <th></th>
         <th>ユーザー名</th>
         <th>年月日</th>
      </tr>
   </thead>
   <tbody>
      @foreach($footprints as $footprint)
      @if($footprint->saw_id != 0)
      <tr>
         <th class="align-middle">
            @if ($footprint->sawGeinin->image == null)
            <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle" width="50" height="50" alt="画像">
            @else
            <img src="{{ Storage::disk('s3')->url('images/' . $footprint->sawGeinin->image) }}" class="rounded-circle" width="50" height="50" alt="画像">
            @endif
         </th>
         <th class="align-middle">
            <a href="{{ url('/profile/' . $footprint->saw_id) }}" target="_blank">{{ $footprint->sawGeinin->user }}さん</a>
         </th>
         <th class="align-middle">{{ $footprint->created_at->format('Y/m/d' )}}</th>
      </tr>
      @else
      <!-- ゲストさん -->
      <tr>
         <th class="align-middle">
            <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle" width="50" height="50" alt="画像">
         </th>
         <th class="align-middle">ゲストさん</th>
         <th class="align-middle">{{ $footprint->created_at->format('Y/m/d' )}}</th>
      </tr>
      @endif
      @break($loop->iteration == 20)
      @endforeach
   </tbody>
</table>
@endsection