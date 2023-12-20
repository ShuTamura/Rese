@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/all_review.css') }}">
@endsection

@section('content')
<div class="all-review">
    <h3 class="all-review__header">{{ $shop->name }}</h3>
    @if($count == 0)
    <p class="all-review__p">この店の口コミはまだありません</p>
    @else
    <p class="all-review__p">この店のすべての口コミ</p>
    @endif
    @foreach($reviews as $review)
    @if( isset($is_admin))
    <div class="all-review">
        <div class="all-review__edit">
            <form action="{{ '/review/delete/' . $review->id }}" class="all-review__delete" method="POST">
                @method('DELETE')
                @csrf
                <button class="all-review__delete-btn">口コミを削除</button>
            </form>
        </div>
        <div class="all-review__wrap">
            <p class="all-review__title">{{ $review->title }}</p>
            <div class="all-review__star">
                <span class="star-review" data-rate="{{ $review->score }}"></span>
            </div>
            <p class="all-review__text">{{ $review->comment }}</p>
        </div>
        <div class="card__img">
            @if($review->image)
            <img src="{{ asset('storage/review_img/' . $review->image) }}" alt="">
            @endif
        </div>
    </div>
    @else
    <div class="all-review">
        <div class="all-review__wrap">
            <p class="all-review__title">{{ $review->title }}</p>
            <div class="all-review__star">
                <span class="star-review" data-rate="{{ $review->score }}"></span>
            </div>
            <p class="all-review__text">{{ $review->comment }}</p>
        </div>
        <div class="card__img">
            @if($review->image)
            <img src="{{ asset('storage/review_img/' . $review->image) }}" alt="">
            @endif
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection
