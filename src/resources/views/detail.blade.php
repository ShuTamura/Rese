@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail__content">
        <div class="detail__back">
            <form class="detail__back-btn">
                @csrf
                <button type="button" onClick="history.back()">&lt</button>
            </form>
        </div>
        <div class="detail__shop-name">
            <h3 class="detail__header">{{ $detail->name }}</h3>
        </div>
    </div>
    <div class="detail__content">
        <div class="detail__img">
            <img src="{{ asset('storage/shop_img/' . $detail->image) }}" alt="">
        </div>
        <div class="detail__tag">
            <p class="detail__item">#{{ $detail->area->name }}</p>
            <p class="detail__item">#{{ $detail->genre->name }}</p>
        </div>
        <p class="detail__description">{{ $detail->detail }}</p>
    </div>
</div>
<div class="reservation">
    <h3 class="reservation__header">予約</h3>
    <div class="reservation__form">
        <form action="/reservation/add" class="form" method="post">
            @csrf
            <div class="form__content">
                <input type="hidden" name="shop_id" class="form__input form__input--hidden" value="{{ $detail->id }}">
                <input type="date" name="date" class="form__input" v-model="date" value="{{ old('date') }}">
                <div class="error-message">
                    @error('date'){{ $message }}@enderror
                </div>
                <input type="time" name="time" class="form__input" v-model="time" step="1800" list="data-list" min="10:00" max="22:00">
                <datalist id="data-list">
                    @for($i=strtotime('10:00'); $i<=strtotime('22:00'); $i=$i+1800 )
                    <option value="{{ date('H:i', $i) }}" ></option>
                    @endfor
                </datalist>
                <div class="error-message">
                    @error('time'){{ $message }}@enderror
                </div>
                <select name="number" class="form__select" v-model="number">
                    <option value='' disabled selected style='display:none;'>人数</option>
                    @for($i=1; $i<=16; $i++ )
                    <option value="{{ $i }}">{{ $i }}人</option>
                    @endfor
                </select>
                <div class="error-message">
                    @error('number'){{ $message }}@enderror
                </div>
            </div>
            <div class="form__content">
                <div class="confirm">
                    <div class="confirm__table">
                        <table>
                            <tr>
                                <td>Shop</td>
                                <td>{{ $detail->name }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>@{{ date }}</td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>@{{ time }}</td>
                            </tr>
                            <tr>
                                <td>Number</td>
                                <td>@{{ number }}人</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form__content">
                <p class="confirm__attention">※予約後にマイページから事前決済ができます。</p>
            </div>
            <div class="form__content">
                <button type="submit" class="form__btn">予約する</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    const app = new Vue({
        el:'#app',
        data: () => {
            return {
                date: '{{ old('date') }}',
                time: '{{ old('time') }}',
                number: '{{ old('number') }}',
            }
        },
        method: {}
    });
</script>
@endsection