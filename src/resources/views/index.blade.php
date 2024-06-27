@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__content">
 <h2>{{ $user['name'] }}さんお疲れ様です！</h2>
  @if(session('success'))
        <p class="attendance__success">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="attendance__error">{{ session('error') }}</p>
    @endif
   <div class="attendance__grid">
    <form class="attendance__button" action="/startwork" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">勤務開始</button>
    </form>
    <form class="attendance__button" action="/endwork" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">勤務終了</button>
    </form>
    <form class="attendance__button" action="/startrest" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">休憩開始</button>
    </form>
    <form class="attendance__button" action="/endrest" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">休憩終了</button>
    </form>
  </div>
</div>
@endsection