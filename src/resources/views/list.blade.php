@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="attendance__content">
  @if (isset($users) && $users->count() > 0)
    <table class="attendance__table">
      <tr class="attendance__row">
        <th class="attendance__label">ID</th>
        <th class="attendance__label">名前</th>
        <th class="attendance__label">メールアドレス</th>
        <th class="attendance__label">ステータス</th>
        <th class="attendance__label"></th>
      </tr>
      @foreach ($users as $user)
      <tr class="attendance__row">
            <td class="attendance__cell">{{ $user['id'] }}</td>
            <td class="attendance__cell">{{ $user['name'] }}</td>
            <td class="attendance__cell">{{ $user['email'] }}</td>
            <td class="attendance__cell">{{ $user['status'] }}</td>
            <td class="attendance__cell">
              <form class="form" action="{{ route('personal.detail', ['id' => $user->id]) }}" method="get">
              <button>勤怠表を見る</button>
            </td>
              </form>
      </tr>
      @endforeach
    </table>
    <div class="pagination__links">
        {{ $users->links() }}  <!-- ページネーションリンクを表示 -->
    </div>
    @endif

</div>
@endsection
