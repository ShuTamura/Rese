@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('content')
<div class="payment">
    <div class="payment__wrap">
        <p class="payment__title">{{ $user->name }}さんのお支払い</p>
        @foreach( $user->reservations as $reservation )
            <div class="payment__content">
                <table class="payment__table">
                    <tr>
                        <td>Shop</td>
                        <td>{{ $reservation->name }}</td>
                    </tr>
                    <tr>
                        <td>日付</td>
                        <td>{{ $reservation->content->date }}</td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td>
                            {{ $reservation->content->time }}
                        </td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td>
                            {{ $reservation->content->number }}人
                        </td>
                    </tr>
                </table>
            @endforeach
        <form action="{{ '/mypage/payment/' . $reservation->content->id }}" method="POST">
            @csrf
            <input type="hidden" name="reservation_id" value="{{ $reservation->content->id }}">
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ env('STRIPE_KEY') }}"
                data-amount="500"
                data-name="Stripe決済デモ"
                data-label="決済をする"
                data-description="デモ決済"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="JPY">
            </script>
        </form>
    </div>
</div>
@endsection