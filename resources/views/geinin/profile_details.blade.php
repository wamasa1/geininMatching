@extends('layouts.geinin')

@section('title', 'プロフィール詳細')

@section('header')
<div class="text-right mt-5">
    <a class="btn btn-primary" href="{{ url()->previous() }}" role="button">
        戻る
    </a>
</div>
<h1 id="title-font" class="mb-5">プロフィール詳細</h1>
@endsection

@section('body')
<!-- お気に入り登録完了メッセージ -->
@include('shared.flash_message', ['message' => 'favorite_success'])
<!-- お気に入り登録解除メッセージ -->
@include('shared.flash_message', ['message' => 'favorite_delete'])
<div style="background-color: ghostwhite;">
    <figure>
        @if ($geinin->image == null)
            <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle mt-5" width="150"
                height="150" alt="画像">
        @else
            <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle mt-5" width="150"
                height="150" alt="画像">
        @endif
        <figcaption>プロフィール画像</figcaption>
    </figure>
    <table id="profile-table" class="table mb-2">
        <thead>
        </thead>
        <tbody>
            <tr>
                <th class="align-middle bg-primary text-white py-3">ユーザー名</th>
                <td class="align-middle">{{ $geinin->user }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">年齢</th>
                <td class="align-middle">{{ $geinin->age }}才</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">希望の活動場所</th>
                <td class="align-middle">{{ $geinin->activity_place }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">漫才とコントのどちらがやりたいですか？</th>
                <td class="align-middle">{{ $geinin->genre }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">ボケとツッコミのどちらを担当したいですか？</th>
                <td class="align-middle">{{ $geinin->role }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">ネタは作りますか？</th>
                <td class="align-middle">{{ $geinin->creater }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">目標</th>
                <td class="align-middle">{{ $geinin->target }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">得意なモノマネ</th>
                <td class="align-middle">{{ $geinin->monomane }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">好きな芸人</th>
                <td class="align-middle">{{ $geinin->favorite_geinin }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">好きなネタ</th>
                <td class="align-middle">{{ $geinin->favorite_neta }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">好きなテレビ番組</th>
                <td class="align-middle">{{ $geinin->favorite_tv_program }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">最近笑ったこと</th>
                <td class="align-middle">{{ $geinin->laughing_event }}</td>
            </tr>
            <tr>
                <th class="align-middle bg-primary text-white py-3">自己紹介</th>
                <td class="align-middle">{{ $geinin->self_introduce }}</td>
            </tr>
        </tbody>
    </table>
    <a class="btn btn-danger my-3" href="{{ action('MessageController@submitForm', $geinin->id) }}">
        {{ $geinin->user }}さんにメッセージを送る
    </a>
    <!-- お気に入り芸人登録・解除ボタン -->
    @include('shared.favorite_button', ['url' => 'search'])
</div>
@endsection