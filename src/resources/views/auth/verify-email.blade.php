@extends('layouts.app')

@section('content')
    <div>
        <div>
            @section('content')
    <div>
        <div>
            @if (session('status') == 'verification-link-sent')
                <div>
                    登録時に提供されたメールアドレスに新しい確認リンクが送信されました。
                </div>
            @endif

            続行する前に、確認リンクが記載されたメールを確認してください。
            メールを受け取っていない場合は、
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">もう一度送信するには、ここをクリックしてください</button>。
            </form>
        </div>
    </div>
@endsection