<!-- プロフィール画像 -->
<figure>
   @if ($geinin->image == null)
   <img src="{{ Storage::disk('s3')->url('images/noimage.png') }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
   @else
   <img src="{{ Storage::disk('s3')->url('images/' . $geinin->image) }}" class="rounded-circle mt-5" width="150" height="150" alt="画像">
   @endif
   <figcaption>プロフィール画像</figcaption>
</figure>
<!-- 芸人テーブル -->
<table id="profile-table" class="table mb-2">
<thead>
</thead>
<tbody>
   <tr>
      <th class="align-middle bg-primary text-white">ユーザー名</th>
      <td><a href="{{ url('/profile/' . $geinin->id) }}">{{ $geinin->user }}</a></td>
   </tr>
   <tr>
      <th class="align-middle bg-primary text-white">希望する活動場所</th>
      <td class="align-middle">{{ $geinin->activity_place }}</td>
   </tr>
   <tr>
      <th class="align-middle bg-primary text-white">漫才とコントのどちらがやりたいですか？</th>
      <td class="align-middle">{{ $geinin->genre }}</td>
   </tr>
   <tr>
      <th class="align-middle bg-primary text-white">ボケとツッコミのどちらを希望しますか？</th>
      <td class="align-middle">{{ $geinin->role }}</td>
   </tr>
   <tr>
      <th class="align-middle bg-primary text-white">ネタは作りますか？</th>
      <td>{{ $geinin->creater }}</td>
   </tr>
   <tr>
      <th class="align-middle bg-primary text-white">目標</th>
      <td>{{ $geinin->target }}</td>
   </tr>
   <tr>
      <th class="align-middle bg-primary text-white">自己紹介</th>
      <td class="align-middle">{{ $geinin->self_introduce }}</td>
   </tr>
</tbody>
</table>
<!-- メッセージ送信 -->
<a class="btn btn-danger mb-2" href="{{ action('MessageController@submitForm', $geinin->id) }}">
{{ $geinin->user }}さんにメッセージを送る
</a>