@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin__content">
    @if(session('message'))
        <p class="message">{{ session('message') }}</p>
    @endif
    <div class="admin__send-mail">
        @if($send_notice)
        <div class="admin__cross">
            <a href="/admin/0" class="back">
                <span class="back__btn"></span>
            </a>
        </div>
        <div class="notice">
            <h3 class="notice__header">お知らせ送信</h3>
            <div class="notice__inner">
                <form action="/admin/send" class="notice-form" method="POST">
                    @csrf
                    <table class="notice-form__table">
                        <tr>
                            <th>件名</th>
                            <td>
                                <input type="text" class="notice-form__input" name="title" value="{{ old('title') }}">
                            </td>
                            <div class="error-message">
                                @error('title'){{ $message }}@enderror
                            </div>
                        </tr>
                        <tr>
                            <th>お知らせ内容</th>
                            <td>
                                <textarea class="notice-form__textarea" name="body" rows="8">{{ old('body') }}</textarea>
                            </td>
                            <div class="error-message">
                                @error('body'){{ $message }}@enderror
                            </div>
                        </tr>
                    </table>
                    <div class="notice-form__btn-box">
                        <button type="submit" class="notice-form__btn">送信</button>
                    </div>
                </form>
            </div>
        </div>
        @else
        <a class="admin__link" href="/admin/1">お知らせメールを送信する</a>
        @endif
    </div>
    <div class="admin__header">
        <p class="admin__title">Users</p>
        <form class="search-form" action="/admin/0/search" method="GET">
            @csrf
            <div class="search-form__flex">
                <div class="form-btn-box">
                    <button type="submit" class="btn"></button>
                </div>
                <input type="search" name="keyword" class="form-item" placeholder="名前で検索" value="{{ request('keyword') }}">
            </div>
        </form>
    </div>
    @foreach( $users as $user )
    <div class="admin__item">
        <div class="admin__user-name">{{ $user->name }}</div>
        <div class="admin__wrap">
            <table class="admin__table" border="1">
                <tr>
                    <th>権限</th>
                    <th>付与</th>
                    <th>削除</th>
                </tr>
                @foreach( $user->roles as $role )
                    @switch ($role->id)
                    @case (1)
                    <tr>
                        <td>
                            <div class="admin__authority" style="background: chartreuse;">
                                {{ $role->name }}
                            </div>
                        </td>
                        <td>
                            <form action="/admin/attach" class="admin-form__attach" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="role_id" class="admin-form__select"  value="">
                                    <option value="1" @if( $role->id == 1) hidden @endif>admin</option>
                                    <option value="2" @if( $role->id == 2) hidden @endif>rep</option>
                                </select>
                                <button class="admin-form__btn admin-form__btn--blue" type="submit">追加</button>
                            </form>
                        </td>
                        <td>
                            <form action="/admin/detach" class="admin-form__detach" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button class="admin-form__btn admin-form__btn--red" type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @break
                    @case (2)
                    <tr>
                        <td>
                            <div class="admin__authority" style="background: cyan;">
                                {{ $role->name }}
                            </div>
                        </td>
                        <td>
                            <form action="/admin/attach" class="admin-form__attach" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="role_id" class="admin-form__select"  value="">
                                    <option value="1" @if( $role->id == 1) hidden @endif>admin</option>
                                    <option value="2" @if( $role->id == 2) hidden @endif>rep</option>
                                </select>
                                <button class="admin-form__btn admin-form__btn--blue" type="submit">追加</button>
                            </form>
                        </td>
                        <td>
                            <form action="/admin/detach" class="admin-form__detach" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button class="admin-form__btn admin-form__btn--red" type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @break
                    @case (3)
                    <tr>
                        <td>
                            <div class="admin__authority" style="background: cornflowerblue;">
                                {{ $role->name }}
                            </div>
                        </td>
                        <td>
                            <form action="/admin/attach" class="admin-form__attach" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="role_id" class="admin-form__select"  value="">
                                    <option value="1" @if( $role->id == 1) hidden @endif>admin</option>
                                    <option value="2" @if( $role->id == 2) hidden @endif>rep</option>
                                </select>
                                <button class="admin-form__btn admin-form__btn--blue" type="submit">追加</button>
                            </form>
                        </td>
                        <td>
                            <form action="/admin/detach" class="admin-form__detach" method="POST">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button class="admin-form__btn admin-form__btn--red" type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endswitch
                @endforeach
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection