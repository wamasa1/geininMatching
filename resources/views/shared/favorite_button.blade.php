<!-- お気に入り芸人登録・解除ボタン -->
<div class="mb-5">
      <form action="{{ url('/'. $url) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="favoriteTo_id" value="{{ $geinin->id }}">
        @auth('geinin')
        @forelse ($geinin->favoriteTo as $favoriteTo)
        @if ($favoriteTo->favoriteFrom_id == $auth_geinin->id)
        @method('delete')
        <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人解除">
        @elseif ($loop->last)
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
        @endif
        @empty
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
        @endforelse
        @else
        @method('patch')
        <input class="btn btn-warning" style="cursor: pointer" type="submit" value="お気に入り芸人登録">
        @endauth
      </form>
    </div>