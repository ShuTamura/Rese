@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
    <p class="thanks__p">会員登録ありがとうございます</p>
    @if (session('status') === 'verification-link-sent')
        <p class="verify-email__guide">
            登録したメールアドレスを確認してください！！
        </p>
        <p class="verify-email__link"><a href="/">TOPに戻る</a></p>
    @else
        <p class="verify-email__guide">
            確認メールを送信してください！！<br>
        </p>
        <form class="verify-email__send-form" method="post" action="{{ route('verification.send') }}">
            @method('post')
            @csrf
            <div>
                <button class="verify-email__form-btn"type="submit">送信</button>
            </div>
        </form>
    @endif
</div>
@endsection