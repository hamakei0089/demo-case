@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/personal.css') }}">
@endsection

@section('content')
<div class="attendance__content">
    <div class="attendance__theme">
        <p class="attendance__name">{{ $user['name'] }}</p>
        <button class="attendance__button-submit" type="button" onClick="history.back()">戻る</button>
    </div>
    <table class="attendance__table">
      <tr class="attendance__row">
        <th class="attendance__label">年月日</th>
        <th class="attendance__label">勤務開始</th>
        <th class="attendance__label">勤務終了</th>
        <th class="attendance__label">休憩時間</th>
        <th class="attendance__label">勤務時間</th>
      </tr>
      @foreach ($attendanceData as $data)
      <tr class="attendance__row">
            <td class="attendance__cell">{{ $data['date'] }}</td>
            <td class="attendance__cell">{{ $data
            ['work_start'] }}</td>
            <td class="attendance__cell">{{ $data['work_end'] }}</td>
            <td class="attendance__cell">{{ $data['rest_duration'] }}</td>
            <td class="attendance__cell">{{ $data['work_duration'] }}</td>
      </tr>
      @endforeach
    </table>
    <div class="pagination__links">
        {{ $stamps->links() }}  <!-- ページネーションリンクを表示 -->
    </div>
</div>
@endsection
