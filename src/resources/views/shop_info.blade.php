@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_info.css') }}">
@endsection

@section('content')
<div class="shop">
    <div class="shop__edit">
        @if($shop)
        <h3 class="shop__header">店舗情報更新</h3>
        <div class="shop__info">
            <form class="create-form" action="/rep/shop/update" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <input type="hidden" name="id" value="{{ $shop->id }}">
                <label for="name" class="create-form__label">店舗名</label>
                <input type="text" name="name" id="name" class="create-form__input" value="{{ $shop->name }}">
                <div class="error-message">
                    @error('name'){{ $message }}@enderror
                </div>
                <div class="create-form__wrap">
                    <label for="area" class="create-form__label">地域</label>
                    <select name="area_id" id="area" class="create-form__select">
                        <option value=""></option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" @if($shop->area->id == $area->id) selected @endif>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="error-message">
                    @error('area_id'){{ $message }}@enderror
                </div>
                <div class="create-form__wrap">
                    <label for="genre" class="create-form__label">ジャンル</label>
                    <select name="genre_id" id="genre" class="create-form__select">
                        <option value=""></option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" @if($shop->genre->id == $genre->id) selected @endif>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="error-message">
                    @error('genre_id'){{ $message }}@enderror
                </div>
                <label for="image" class="create-form__label">店舗画像</label>
                <input type="file" name="image" class="create-form__input">
                <div class="create-form__wrap">
                    <textarea name="detail" cols="30" rows="5" class="create-form__textarea" placeholder="店舗詳細">{{ $shop->detail }}</textarea>
                </div>
                <div class="error-message">
                    @error('detail'){{ $message }}@enderror
                </div>
                <button class="create-form__btn">更新</button>
                @if(session('message'))
                <p class="message">{{ session('message') }}</p>
                @endif
            </form>
        </div>
        @else
        <h3 class="shop__header">店舗情報作成</h3>
        <div class="shop__info">
            <form class="create-form" action="/rep/shop/add" class="shop-date" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <label for="name" class="create-form__label">店舗名</label>
                <input type="text" name="name" id="name" class="create-form__input" value="{{ old('name') }}">
                <div class="error-message">
                    @error('name'){{ $message }}@enderror
                </div>
                <div class="create-form__wrap">
                    <label for="area" class="create-form__label">地域</label>
                    <select name="area_id" id="area" class="create-form__select">
                        <option value=""></option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id }}" @if((int)old('area_id') == $area->id) selected @endif>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="error-message">
                    @error('area_id'){{ $message }}@enderror
                </div>
                <div class="create-form__wrap">
                    <label for="genre" class="create-form__label">ジャンル</label>
                    <select name="genre_id" id="genre" class="create-form__select">
                        <option value=""></option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" @if((int)old('genre_id') == $genre->id) selected @endif>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="error-message">
                    @error('genre_id'){{ $message }}@enderror
                </div>
                <label for="image" class="create-form__label">店舗画像</label>
                <input type="file" name="image" class="create-form__input">
                <div class="create-form__wrap">
                    <textarea name="detail" cols="30" rows="5" class="create-form__textarea" placeholder="店舗詳細"></textarea>
                </div>
                <div class="error-message">
                    @error('detail'){{ $message }}@enderror
                </div>
                <button class="create-form__btn">作成</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection