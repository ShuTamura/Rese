@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visited.css') }}">
@endsection

@section('content')
<div class="visited__content">
    <p class="visited__title">来店済みのお店</p>
    @foreach( $reviews as $review )
    <div class="visited__item">
        <div class="visited__shop-img">
            <img src="{{ asset('storage/shop_img/' . $review->shop->image) }}" alt="">
        </div>
        <div class="visited__wrap">
            <div class="visited__shop-name">{{ $review->shop->name }}</div>
            <div class="visited__shop-tag">
                <div class="visited__shop-area">#{{ $review->shop->area->name }}</div>
                <div class="visited__shop-genre">#{{ $review->shop->genre->name }}</div>
            </div>
            <div class="visited__shop-detail">{{ $review->shop->detail }}</div>
        </div>
        <div class="visited__link">
            <a href="{{ '/review/shop/' . $review->shop->id}}">REVIEW</a>
        </div>
    </div>
    @endforeach
</div>
@endsection