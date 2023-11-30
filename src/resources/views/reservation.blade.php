@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('content')
<div class="reservation">
    <div class="reservation__list">
        <h3 class="reservation__header">予約一覧</h3>
        <p class="reservation__p">名前をクリックするとQRコード照合用の予約詳細ページに遷移します。</p>
        <form class="search-form" action="/rep/reservation/search" method="GET">
            @csrf
            <div class="search-form__flex">
                <input type="date" name="date" class="form-item">
                <input type="search" name="keyword" class="form-item" placeholder="名前で検索" value="{{ request('keyword') }}">
                <div class="form-btn-box">
                    <button type="submit" class="btn"></button>
                </div>
            </div>
        </form>
        <p class="reservation__p">{{ request('date') }}</p>
        <table class="reservation-table" border="1">
            <tr>
                <th>予約者</th>
            </tr>
            @foreach( $reservations as $reservation )
            <tr>
                <td>
                    <a href="{{ '/rep/reservation/' . $reservation->id }}" class="reservation-info__link">{{ $reservation->user->name }}</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection