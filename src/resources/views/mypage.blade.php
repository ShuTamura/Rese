@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__content">
        <div class="mypage__review">
            <a href="/mypage/visited">来店済みのお店を評価</a>
        </div>
        <div class="mypage__user-name">
            <h2 class="mypage__hello">{{ Auth::user()->name }}さん</h2>
        </div>
    </div>
    <div class="mypage__content">
        <div class="reservation">
            <h3 class="reservation__header">予約状況</h3>
            @php $n = 1 @endphp
            @foreach( $user->reservations as $reservation )
            <div class="reservation__edit">
                <form class="edit-form" action="/reservation/update" method="POST">
                @method('PATCH')
                @csrf
                    <input type="hidden" name="id" value="{{ $reservation->content->id }}">
                    <div class="edit-form__table">
                        <table>
                            <tr><th>予約{{ $n }}</th></tr>
                            <tr>
                                <td>Shop</td>
                                <td>{{ $reservation->name }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td><input type="date" name="date" class="edit-form__input"  value="{{ $reservation->content->date }}"></td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>
                                    <input type="time" name="time" class="edit-form__input" value="{{ $reservation->timeFormat($reservation->content->time) }}" step="1800" list="data-list" min="10:00" max="22:00">
                                    <datalist id="data-list">
                                        @for($i=strtotime('10:00'); $i<=strtotime('22:00'); $i=$i+1800 )
                                        <option value="{{ date('H:i', $i) }}"></option>
                                        @endfor
                                    </datalist>
                                </td>
                            </tr>
                            <tr>
                                <td>Number</td>
                                <td>
                                    <select name="number" class="edit-form__select"  value="{{ $reservation->content->number }}">
                                        @for($i=1; $i<=8; $i++ )
                                        <option value="{{ $i }}" @if((int)$reservation->content->number == $i) selected @endif>{{ $i }}人</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <button type="submit" class="edit-form__btn">予約内容を変更</button>
                        @if( !empty(session('message')) && session('id') == $reservation->content->id )
                        <div>
                            <p class="message">{{ session('message')}}</p>
                        </div>
                        @endif
                    </div>
                </form>
                <div class="reservation__cross">
                    <form action="/reservation/delete" class="delete-form" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="shop_id" class="delete-form__input" value="{{ $reservation->id }}">
                        <button type="submit" class="delete-form__btn"></button>
                    </form>
                </div>
                <div class="reservation__btn">
                    <a href="{{ '/mypage/qr/' . $reservation->content->id }}" class="qrcode">QRコード</a>
                    @if($reservation->content->payment)
                    <span class="payment payment__paid">決済完了</span>
                    @else<a href="{{ '/mypage/payment/' . $reservation->content->id }}" class="payment">決済</a>
                    @endif
                </div>
            </div>
            @php
            $n = $n+1
            @endphp
            @endforeach
        </div>
        <div class="favorite-shop">
            <h3 class="favorite-shop__header">お気に入り店舗</h3>
            <div class="favorite-shop__list">
                @foreach( $user->favorites as $favorite )
                <div class="card">
                    <div class="card__img">
                        <img src="{{ asset('storage/shop_img/' . $favorite->image) }}" alt="">
                    </div>
                    <div class="card__content">
                        <h3 class="card__shop-name">{{ $favorite->name }}</h3>
                        <div class="card__tag">
                            <p class="card__item">#{{ $favorite->area->name }}</p>
                            <p class="card__item">#{{ $favorite->genre->name }}</p>
                        </div>
                        <div class="card__jump">
                            <div class="card__detail">
                                <a href="{{ '/detail/' . $favorite->id }}" class="card__link">詳しくみる</a>
                            </div>
                            <div class="heart">
                                @if( Auth::check() )
                                @if( null == $favorite->getFavorite( $favorite->id ) )
                                <form action="/favorite/add" class="heart__form" method="POST">
                                    @csrf
                                    <input type="hidden" name="shop_id" class="heart__input" value="{{ $favorite->id }}">
                                    <button type="submit" class="heart__btn heart__btn--gray"></button>
                                </form>
                                @else
                                <form action="/favorite/delete" class="heart__form heart__form--favorite" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="shop_id" class="heart__input" value="{{ $favorite->id }}">
                                    <button type="submit" class="heart__btn heart__btn--red"></button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection