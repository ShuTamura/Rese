@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <p class="register__title">Registration</p>
    <form action="/register" class="form" method="POST">
        @csrf
        <div class="name-form">
            <img class="user-icon" src="{{ asset('storage/icons/user_icon.svg') }}" width="30px" alt="user">
            <input type="name" class="form__item" name="name" placeholder="Username" value="{{ old('name') }}">
        </div>
        <div class="error-message">
            @error('name'){{ $message }}@enderror
        </div>
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
        </div>
        <div class="register-btn">
            <button type="submit" class="btn">登録</button>
        </div>
    </form>
</div>
@endsection