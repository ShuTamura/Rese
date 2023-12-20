@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review__content">
    <p class="review__title">Review</p>
    <div class="review__item">
        <div class="review__shop-img">
            <img src="{{ asset('storage/shop_img/' . $review->shop->image) }}" alt="">
        </div>
        <div class="review__wrap">
            <div class="review__shop-name">{{ $review->shop->name }}</div>
            <div class="review__shop-tag">
                <div class="review__shop-area">#{{ $review->shop->area->name }}</div>
                <div class="review__shop-genre">#{{ $review->shop->genre->name }}</div>
            </div>
            <form action="{{ '/mypage/review/' . $review->id }}" class="review__form" method="POST">
                @method('PATCH')
                @csrf
                <input type="hidden" name="id" value="{{ $review->id }}">
                <div class="review__score">
                    <div class="score-form">
                        <input id="star5" type="radio" name="score" value="5" @if(5 == $review->score) checked @endif>
                        <label for="star5">★</label>
                        <input id="star4" type="radio" name="score" value="4" @if(4 == $review->score) checked @endif>
                        <label for="star4">★</label>
                        <input id="star3" type="radio" name="score" value="3" @if(3 == $review->score) checked @endif>
                        <label for="star3">★</label>
                        <input id="star2" type="radio" name="score" value="2" @if(2 == $review->score) checked @endif>
                        <label for="star2">★</label>
                        <input id="star1" type="radio" name="score" value="1" @if(1 == $review->score) checked @endif>
                        <label for="star1">★</label>
                    </div>
                </div>
                <button type="submit" class="review__btn">レビューを送信</button>
                <div class="review__comment">
                    <textarea name="comment" rows="5" placeholder="感想等お聞かせください">{{ $review->comment }}</textarea>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection