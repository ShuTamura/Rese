@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <p class="login__title">login</p>
    <form action="/login" class="form" method="POST">
        @csrf
        <div class="email-form">
            <img class="email-icon" src="{{ asset('storage/icons/email_icon.svg') }}" width="30px" alt="email">
            <input type="email" class="form__item" name="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="error-message">
            @error('email'){{ $message }}@enderror
        </div>
        <div class="password-form">
            <img class="key-icon" src="{{ asset('storage/icons/key_icon.svg') }}" width="30px" alt="password">
            <input type="password" class="form__item" name="password" placeholder="Password" value="{{ old('password') }}">
        </div>
        <div class="error-message">
            @error('password'){{ $message }}@enderror
            @if(session('error'))
            {{ session('error') }}
            @endif
        </div>
        <div class="login-btn">
            <button type="submit" class="btn">ログイン</button>
        </div>
    </form>
</div>
@endsection