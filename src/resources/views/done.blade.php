@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done">
    <p class="done__p">ご予約ありがとうございます</p>
    <p class="done__p">予約状況はマイページからご確認ください</p>
    <p class="done__p">マイページから事前支払い可能です</p>
    <div class="done__link">
        <form class="done__form">
            @csrf
            <button class="done__btn" type="button" onClick="history.back()">戻る</button>
        </form>
    </div>
</div>
@endsection