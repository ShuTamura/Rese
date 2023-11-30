@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/rep.css') }}">
@endsection

@section('content')
<div class="rep">
    <div class="rep__tab">
        <div class="rep__shop-info">
            <a href="/rep/shop">店舗情報作成・更新</a>
        </div>
        <div class="rep__reservation">
            <a href="/rep/reservation">予約情報</a>
        </div>
    </div>
    @if($shop)
    <div class="rep__hello">
        <p class="rep__p"><span>店舗</span>{{ $shop->name }}</p>
        <p class="rep__p"><span>代表者</span>{{ $user->name }}<span>様</span></p>
    </div>
    @else
    <div class="rep__alert">
        <p class="rep__p">{{ $user->name }}様</p>
        <p class="rep__p">店舗情報の登録が完了していません。<br>上部のタブから登録できます。</p>
    </div>
    @endif
</div>
@endsection