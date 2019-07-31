@extends('layouts.geinin')

@section('title', 'プロフィール編集')

@section('header')
  <div class="text-right mt-3">
    <a class="btn btn-primary" href="{{ url('/profile') }}" role="button">
      戻る
    </a>
  </div>
  <h1 id="title-font" class="display-3 pt-2 mt-2 mb-5">プロフィール編集</h1>
@endsection

@section('body')
  <h2 class="my-5">どれを選ぶかにより「相性の良い相方」が異なりますので、正確に選びましょう。</h2>
  <form action="{{ url('/profile/edit') }}" method="post">
    {{ csrf_field() }}
    <table id="profile-table" class="table table-hover">
      <thead>
      </thead>
      <tbody>
        <!-- ユーザー名 -->
        <tr>
          <th class="align-middle bg-success text-white">
            ユーザー名<span class="text-danger">(必須)</span>
          </th>
          <td class="align-middle text-center">
            @if ($geinin->user == '松本紳助（テスト）')
              <span>{{ $geinin->user }}</span><br>
              <span class="text-danger">※テストユーザーは、ユーザー名を変更できません</span>
            @else
              <input type="text" name="user" value="{{ $geinin->user }}"><br>
            @endif
            @if ($errors->has('user'))
              <p class="text-danger">{{ $errors->first('user') }}</p>
            @endif
          </td>
        </tr>

        <!-- 年齢 -->
        <tr>
          <th class="align-middle bg-success text-white">誕生日</th>
          <td class="text-center">
            <select name="birthday_year">
                @for ($i = 1950; $i < $this_year -15; $i++) {{--15才以上--}}
                    <option value={{ $i }} {{ $i == $geinin->birthday_year ? 'selected' : '' }}>{{ $i }}年</option>
                @endfor
            </select>
            <select name="birthday_month">
                @for ($i = 1; $i <= 12; $i++)
                    <option value={{ $i }} {{ $i == $geinin->birthday_month ? 'selected' : '' }}>{{ $i }}月</option>
                @endfor
            </select>
            <select name="birthday_day">
                @for ($i = 1; $i <= 31; $i++)
                    <option value={{ $i }} {{ $i == $geinin->birthday_day ? 'selected' : '' }}>{{ $i }}日</option>
                @endfor
            </select>
          </td>
        </tr>

        <!-- 希望する活動場所 -->
        <tr>
          <th class="align-middle bg-success text-white">希望する活動場所<span class="text-danger">(必須)</span></th>
          <td class="text-center">
            <select name="activity_place">
              <option {{ $geinin->activity_place == '東京' ? 'selected' : '' }}>東京</option>
              <option {{ $geinin->activity_place == '大阪' ? 'selected' : '' }}>大阪</option>
              <option {{ $geinin->activity_place == '福岡' ? 'selected' : '' }}>福岡</option>
              <option {{ $geinin->activity_place == '仙台' ? 'selected' : '' }}>仙台</option>
              <option {{ $geinin->activity_place == '札幌' ? 'selected' : '' }}>札幌</option>
              <option {{ $geinin->activity_place == '沖縄' ? 'selected' : '' }}>沖縄</option>
            </select>
          </td>
        </tr>

        <!-- ジャンル -->
        <tr>
          <th class="align-middle bg-success text-white">あなたは、漫才とコントのどちらがやりたいですか？<span class="text-danger">(必須)</span> </th>
          <td class="text-center">
            <input type="radio" id="manzai" name="genre" value="漫才" {{ $geinin->genre == '漫才' ? 'checked' : '' }}><label for="manzai">漫才</label><br>
            <input type="radio" id="konto" name="genre" value="コント" {{ $geinin->genre == 'コント' ? 'checked' : '' }}><label for="konto">コント</label><br>
            <input type="radio" id="manzai_konto" name="genre" value="両方" {{ $geinin->genre == '両方' ? 'checked' : '' }}><label for="manzai_konto">両方</label><br>
            @if ($errors->has('genre'))
              <p class="text-danger">{{ $errors->first('genre') }}</p>
            @endif
          </td>
        </tr>

        <!-- ボケかツッコミか -->
        <tr>
          <th class="align-middle bg-success text-white">
            あなたは、ボケとツッコミのどちらを担当したいですか？<span class="text-danger">(必須)</span>
          </th>
          <td class="text-center">
            <input type="radio" id="boke" name="role" value="ボケ" {{ $geinin->role == 'ボケ' ? 'checked' : '' }}><label for="boke">ボケ</label><br>
            <input type="radio" id="tukkomi" name="role" value="ツッコミ" {{ $geinin->role == 'ツッコミ' ? 'checked' : '' }}><label for="tukkomi">ツッコミ</label><br>
            <input type="radio" id="boke_tukkomi" name="role" value="こだわらない" {{ $geinin->role == 'こだわらない' ? 'checked' : '' }}><label for="boke_tukkomi">こだわらない</label>
            @if ($errors->has('role'))
              <p class="text-danger">{{ $errors->first('role') }}</p>
            @endif
          </td>
        </tr>

        <!-- ネタ作り -->
        <tr>
          <th class="align-middle bg-success text-white">ネタは作りますか？<span class="text-danger">(必須)</span></th>
          <td class="text-center">
            <input type="radio" id="me" name="creater" value="自分が作る" {{ $geinin->creater == '自分が作る' ? 'checked' : '' }}><label for="me">自分が作る</label><br>
            <input type="radio" id="together" name="creater" value="一緒に作りたい" {{ $geinin->creater == '一緒に作りたい' ? 'checked' : '' }}><label for="together">一緒に作りたい</label><br>
            <input type="radio" id="you" name="creater" value="相方に作ってほしい" {{ $geinin->creater == '相方に作ってほしい' ? 'checked' : '' }}><label for="you">相方に作ってほしい</label>
            @if ($errors->has('creater'))
              <p class="text-danger">{{ $errors->first('creater') }}</p>
            @endif
          </td>
        </tr>

        <!-- 目標 -->
        <tr>
          <th class="align-middle bg-success text-white">あなたの目標は何ですか？<span class="text-danger">(必須)</span></th>
          <td class="text-center">
            <input type="radio" id="golden" name="target" value="ゴールデンで冠番組を持つ" {{ $geinin->target == 'ゴールデンで冠番組を持つ' ? 'checked' : '' }}><label for="golden">ゴールデンで冠番組を持つ</label><br>
            <input type="radio" id="midnight" name="target" value="深夜でもいいから、面白い番組がしたい" {{ $geinin->target == '深夜でもいいから、面白い番組がしたい' ? 'checked' : '' }}><label for="midnight">深夜でもいいから、面白い番組がしたい</label><br>
            <input type="radio" id="theater" name="target" value="テレビよりも舞台で活躍したい" {{ $geinin->target == 'テレビよりも舞台で活躍したい' ? 'checked' : '' }}><label for="theater">テレビよりも舞台で活躍したい</label>
            @if ($errors->has('target'))
              <p class="text-danger">{{ $errors->first('target') }}</p>
            @endif
          </td>
        </tr>

        <!-- 得意なモノマネ -->
        <tr>
          <th class="align-middle bg-success text-white">得意なモノマネ</th>
          <td class="text-center">
            <textarea name="monomane" rows="1" cols="40">{{ $geinin->monomane }}</textarea>
          </td>
        </tr>
        <!-- 好きな芸人 -->
        <tr>
          <th class="align-middle bg-success text-white">好きな芸人</th>
          <td class="text-center">
            <textarea name="favorite_geinin" rows="1" cols="40">{{ $geinin->favorite_geinin }}</textarea>
          </td>
        </tr>
        <!-- 好きなネタ -->
        <tr>
          <th class="align-middle bg-success text-white">好きなネタ</th>
          <td class="text-center">
            <textarea name="favorite_neta" rows="1" cols="40">{{ $geinin->favorite_neta }}</textarea>
          </td>
        </tr>
        <!-- 好きなテレビ番組 -->
        <tr>
          <th class="align-middle bg-success text-white">好きなテレビ番組</th>
          <td class="text-center">
            <textarea name="favorite_tv_program" rows="1" cols="40">{{ $geinin->favorite_tv_program }}</textarea>
          </td>
        </tr>
        <!-- 最近笑ったこと -->
        <tr>
          <th class="align-middle bg-success text-white">最近笑ったこと</th>
          <td class="text-center">
            <textarea name="laughing_event" rows="1" cols="40" placeholder="">{{ $geinin->laughing_event }}</textarea>
          </td>
        </tr>
        <!-- 自己紹介 -->
        <tr>
          <th class="align-middle bg-success text-white">自己紹介</th>
          <td class="text-center">
            <textarea name="self_introduce" rows="4" cols="40" placeholder="">{{ $geinin->self_introduce }}</textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <input class="btn-success btn-lg" type="submit" value="完了">
  </form>
@endsection