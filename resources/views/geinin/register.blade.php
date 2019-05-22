@extends('layouts.geinin')

@section('title', '新規登録画面')

@section('header')
<div class="text-right mt-1">
  <a class="btn btn-primary" href="{{ url('/index') }}" role="button">
    ホーム
  </a>
</div>
<h1 class="display-3 pt-2 mt-2 mb-5">新規登録画面</h1>
@endsection

@section('body')
<h2 class="my-5">あなたの情報を登録することで、相性の良い相方を探します。</h2>
<form action="{{ url('/show') }}" method="post">
  {{ csrf_field() }}
  <table id="question" class="table table-hover">
    <thead>
    </thead>
    <tbody>
      <tr>
        <th class="align-middle bg-primary text-white">
          ユーザー名<span class="text-danger">(必須)</span>
        </th>
        <td class="text-center">
          <input type="text" name="user" value="{{ old('user' )}}"><br>
          @if ($errors->has('user'))
          <p class="text-danger">{{ $errors->first('user') }}</p>
          @endif
        </td>
      </tr>

      <!-- ジャンル -->
      <tr>
        <th class="align-middle bg-primary text-white">あなたは、漫才とコントのどちらがやりたいですか？<span class="text-danger">(必須)</span> </th>
        <td class="text-center">
          <input type="radio" id="manzai" name="genre" value="漫才" {{ old('genre') == '漫才' ? 'checked' : '' }}><label for="manzai">漫才</label><br>
          <input type="radio" id="konto" name="genre" value="コント" {{ old('genre') == 'コント' ? 'checked' : '' }}><label for="konto">コント</label><br>
          <input type="radio" id="manzai_konto" name="genre" value="両方" {{ old('genre') == '両方' ? 'checked' : '' }}><label for="manzai_konto">両方</label><br>
          @if ($errors->has('genre'))
          <p class="text-danger">{{ $errors->first('genre') }}</p>
          @endif
        </td>
      </tr>

      <!-- ボケかツッコミか -->
      <tr>
        <th class="align-middle bg-primary text-white">
          あなたは、ボケとツッコミのどちらを担当したいですか？<span class="text-danger">(必須)</span>
        </th>
        <td class="text-center">
          <input type="radio" id="boke" name="role" value="ボケ" {{ old('role') == 'ボケ' ? 'checked' : '' }}><label for="boke">ボケ</label><br>
          <input type="radio" id="tukkomi" name="role" value="ツッコミ" {{ old('role') == 'ツッコミ' ? 'checked' : '' }}><label for="tukkomi">ツッコミ</label><br>
          <input type="radio" id="boke_tukkomi" name="role" value="こだわらない" {{ old('role') == 'こだわらない' ? 'checked' : '' }}><label for="boke_tukkomi">こだわらない</label>
          @if ($errors->has('role'))
          <p class="text-danger">{{ $errors->first('role') }}</p>
          @endif
        </td>
      </tr>

      <!-- ネタ作り -->
      <tr>
        <th class="align-middle bg-primary text-white">ネタは作りますか？<span class="text-danger">(必須)</span></th>
        <td class="text-center">
          <input type="radio" id="me" name="creater" value="自分が作る" {{ old('creater') == '自分が作る' ? 'checked' : '' }}><label for="me">自分が作る</label><br>
          <input type="radio" id="together" name="creater" value="一緒に作りたい" {{ old('creater') == '一緒に作りたい' ? 'checked' : '' }}><label for="together">一緒に作りたい</label><br>
          <input type="radio" id="you" name="creater" value="相方に作ってほしい" {{ old('creater') == '相方に作ってほしい' ? 'checked' : '' }}><label for="you">相方に作ってほしい</label>
          @if ($errors->has('creater'))
            <p class="text-danger">{{ $errors->first('creater') }}</p>
          @endif
        </td>
      </tr>

      <!-- 目標 -->
      <tr>
        <th class="align-middle bg-primary text-white">あなたの目標は何ですか？<span class="text-danger">(必須)</span></th>
        <td class="text-center">
          <input type="radio" id="golden" name="target" value="ゴールデンで冠番組を持つ" {{ old('target') == 'ゴールデンで冠番組を持つ' ? 'checked' : '' }}><label for="golden">ゴールデンで冠番組を持つ</label><br>
          <input type="radio" id="midnight" name="target" value="深夜でもいいから、面白い番組がしたい" {{ old('target') == '深夜でもいいから、面白い番組がしたい' ? 'checked' : '' }}><label for="midnight">深夜でもいいから、面白い番組がしたい</label><br>
          <input type="radio" id="theater" name="target" value="テレビよりも舞台で活躍したい" {{ old('target') == 'テレビよりも舞台で活躍したい' ? 'checked' : '' }}><label for="theater">テレビよりも舞台で活躍したい</label>
          @if ($errors->has('target'))
            <p class="text-danger">{{ $errors->first('target') }}</p>
          @endif
        </td>
      </tr>

      <!-- 自己紹介 -->
      <tr>
        <th class="align-middle bg-primary text-white">自己紹介</th>
        <td class="text-center">
          <textarea name="self_introduce" rows="4" cols="40" placeholder="好きな芸人、特技、できるモノマネなど" value="{{ old('self_introduce')}}" ></textarea>
        </td>
      </tr>
      <!-- email password -->
      <tr>
        <th class="align-middle bg-dark text-white">
          メールアドレス<span class="text-danger">(必須)</span>
        </th>
        <td>
          <input type="email" name="email" value="{{ old('email') }}">
          @if ($errors->has('email'))
          <p class="text-danger">{{ $errors->first('email') }}</p>
          @endif
        </td>
      </tr>
      <tr>
        <th class="align-middle bg-dark text-white">
          パスワード(4文字以上)<span class="text-danger">(必須)</span>
        </th>
        <td>
          <input type="password" name="password">
          @if ($errors->has('password'))
          <p class="text-danger">{{ $errors->first('password') }}</p>
          @endif
        </td>
      </tr>
    </tbody>
  </table>
  <input class="btn-primary btn-lg" type="submit" value="新規登録">
</form>
@endsection
