@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="sort">
    <form action="/sort" class="sort-form">
        <label for="sort" class="sort-form_label">並べ替え：</label>
        <select name="sort" id="sort" class="sort-form__select" onchange="submit(this.form)">
            <option value="">評価高/低</option>
            <option value="random">ランダム</option>
            <option value="hight_score">評価が高い順</option>
            <option value="low_score">評価が低い順</option>
        </select>
    </form>
</div>
<div class="search-form-box">
    {{old('keyword')}}
    <form class="search-form" action="/search" method="GET">
        @csrf
        <select name="area_id" class="form-item" >
            <option value="">All area</option>
            @foreach($areas as $area)
            <option value="{{ $area->id }}" @if((int)request('area_id') == $area->id) selected @endif>{{ $area->name }}</option>
            @endforeach
        </select>
        <select name="genre_id" class="form-item">
            <option value="">All genre</option>
            @foreach($genres as $genre)
            <option value="{{ $genre->id }}" @if((int)request('genre_id') == $genre->id) selected @endif>{{ $genre->name }}</option>
            @endforeach
        </select>
        <div class="form-btn-box">
            <button type="submit" class="btn"></button>
        </div>
        <input type="search" name="keyword" class="form-item" placeholder="Search ..." value="{{ request('keyword') }}">
    </form>
</div>
<div class="wrap">
    @foreach($shops as $shop)
    <div class="card">
        <div class="card__img">
            <img src="{{ asset('storage/shop_img/' . $shop->image) }}" alt="">
        </div>
        <div class="card__content">
            <h3 class="card__shop-name">{{ $shop->name }}</h3>
            <p class="card__shop-p">
                <span class="card__shop-span card__shop-span--blue">★</span>
                <span class="card__shop-span card__shop-span--black">：</span>
                {{ $shop->all_score }}
            </p>
            <div class="card__tag">
                <p class="card__item">#{{ $shop->area->name }}</p>
                <p class="card__item">#{{ $shop->genre->name }}</p>
            </div>
            <div class="card__jump">
                <div class="card__detail">
                    <a href="{{ '/detail/' . $shop->id }}" class="card__link">詳しくみる</a>
                </div>
                <div class="heart">
                    @if( Auth::check() )
                    @if( null == $shop->getFavorite( $shop->id ) )
                    <form action="/favorite/add" class="heart__form" method="POST">
                        @csrf
                        <input type="hidden" name="shop_id" class="heart__input" value="{{ $shop->id }}">
                        <button type="submit" class="heart__btn heart__btn--gray"></button>
                    </form>
                    @else
                    <form action="/favorite/delete" class="heart__form heart__form--favorite" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="shop_id" class="heart__input" value="{{ $shop->id }}">
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
@endsection