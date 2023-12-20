@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div id="app" class="edit-review">
    @if(!$review)
    <div class="confirm">
        <p class="confirm__p">来店したことがありますか？</p>
        <div class="confirm__wrap">
            <form action="{{ '/review/shop/' . $shop_id }}" class="confirm-form" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $shop_id }}">
                <button class="confirm-form__button-submit" type="submit">はい</button>
            </form>
            <a href="#" class="confirm__back" onClick="history.back()">戻る</a>
        </div>
    </div>
    @else
    <div class="edit-review__content">
        <form action="{{ '/review/update/' . $review->id }}" class="edit-review__form" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="edit-review__flex">
                <div class="edit-review__left">
                    <h3 class="edit-review__header">今回のご利用はいかがでしたか？</h3>
                    <div class="card">
                        <div class="card__img">
                            <img src="{{ asset('storage/shop_img/' . $review->shop->image) }}" alt="">
                        </div>
                        <div class="card__content">
                            <h3 class="card__shop-name">{{ $review->shop->name }}</h3>
                            <div class="card__tag">
                                <p class="card__item">#{{ $review->shop->area->name }}</p>
                                <p class="card__item">#{{ $review->shop->genre->name }}</p>
                            </div>
                            <div class="card__jump">
                                <div class="card__detail">
                                    <a href="{{ '/detail/' . $review->shop->id }}" class="card__link">詳しくみる</a>
                                </div>
                                <div class="heart">
                                    @if( Auth::check() )
                                        @if( null == $review->shop->getFavorite( $review->shop->id ) )
                                            <div class="heart__btn heart__btn--gray"></div>
                                        @else
                                            <div class="heart__btn heart__btn--red"></div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="edit-review__right">
                    <p class="edit-review__p">口コミタイトル</p>
                    <input type="text" name="title" class="edit-review__input"
                        @if(is_null($review->title) || $errors->any()) value="{{ old('title') }}"
                        @else value="{{ $review->title }}"
                        @endif>
                    <div class="error-message">
                        @error('title'){{ $message }}@enderror
                    </div>
                    <p class="edit-review__p">体験を評価してください</p>
                    <div class="review__score">
                        @if( $review->comment == null || $errors->any() )
                        <div class="score-form">
                            <input id="star5" type="radio" name="score" value="5" @if(5 == old('score')) checked @endif>
                            <label for="star5">★</label>
                            <input id="star4" type="radio" name="score" value="4" @if(4 == old('score')) checked @endif>
                            <label for="star4">★</label>
                            <input id="star3" type="radio" name="score" value="3" @if(3 == old('score')) checked @endif>
                            <label for="star3">★</label>
                            <input id="star2" type="radio" name="score" value="2" @if(2 == old('score')) checked @endif>
                            <label for="star2">★</label>
                            <input id="star1" type="radio" name="score" value="1" @if(1 == old('score')) checked @endif>
                            <label for="star1">★</label>
                        </div>
                        @else
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
                        @endif
                    </div>
                    <p class="error-message">
                        @error('score'){{ $message }}@enderror
                    </p>
                    <p class="edit-review__p">口コミを投稿</p>
                    @if( $review->comment == null || $errors->any() )
                    <textarea name="comment" id="" cols="30" rows="10" class="edit-review__textarea" maxlength="400" placeholder="口コミ" v-model.trim="count">{{ old('comment') }}</textarea>
                    @else
                    <textarea name="comment" id="" cols="30" rows="10" class="edit-review__textarea" maxlength="400" placeholder="口コミを入力" v-model.trim="comment"></textarea>
                    @endif
                    <p class="error-message">
                        @error('comment'){{ $message }}@enderror
                    </p>
                    @if( $review->comment == null || $errors->any() )
                    <p class="edit-review__counter">@{{ count.length }}/400文字（最高文字数）</p>
                    @else
                    <p class="edit-review__counter">@{{ comment.length }}/400文字（最高文字数）</p>
                    @endif
                    <p class="edit-review__p">画像の追加</p>
                    <div class="edit-review__dropzone">
                        <p>@{{ image }}</p>
                        <p class="edit-review__click">クリックして写真を追加</p>
                        <span class="edit-review__span">またはドラッグアンドドロップ</span>
                        <input type="file" name="image" class="edit-review__input" v-model.trim="image" value="{{ $review->image }}">
                    </div>
                    <p class="error-message">
                        @error('image'){{ $message }}@enderror
                    </p>
                </div>
            </div>
            <div class="edit-review__btn-wrap">
                <button type="submit" class="edit-review__btn">口コミを投稿</button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection

@section('js')
@if($review)
<script>
    new Vue({
        el:'#app',
        data: {
            count: "{{ old('comment') }}",
            comment: "{{ $review->comment }}",
            image: "",
        }
    });
</script>
@endif
@endsection
