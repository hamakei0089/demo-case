@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance__content">
  <div class="attendance__days">
  <form action="/attendance" method="get">
    <input type="hidden" name="date" value="{{ $previousDate }}">
    <button type="submit"class="day__select-button">＜</button>
  </form>
  <h2>{{ $currentDate->toDateString() }}</h2>
  <form action="/attendance" method="get">
        <input type="hidden" name="date" value="{{ $nextDate }}">
        @if ($currentDate->isToday())
            <button type="submit" disabled>→</button>
        @else
            <button type="submit" class="day__select-button">＞</button>
        @endif
  </div>
  </form>
  @if (session('message'))
    <p>{{ session('message') }}</p>
  @else
    @if (isset($attendanceData))
    <table class="attendance__table">
      <tr class="attendance__row">
        <th class="attendance__label">名前</th>
        <th class="attendance__label">勤務開始</th>
        <th class="attendance__label">勤務終了</th>
        <th class="attendance__label">休憩時間</th>
        <th class="attendance__label">勤務時間</th>
      </tr>
      @foreach ($attendanceData as $data)
      <tr class="attendance__row">
            <td class="attendance__cell">{{ $data['name'] }}</td>
            <td class="attendance__cell">{{ $data['work_start'] }}</td>
            <td class="attendance__cell">{{ $data['work_end'] }}</td>
            <td class="attendance__cell">{{ $data['rest_duration'] }}</td>
            <td class="attendance__cell">{{ $data['work_duration'] }}</td>
      </tr>
      @endforeach
    </table>
    @else
    <p>指定された日付には勤務データがありません。</p>
    @endif
  @endif
       {{ $stamps->links('vendor.pagination.bootstrap-4') }}
</div>
@endsection
