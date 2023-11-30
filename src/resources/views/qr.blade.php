@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qr.css') }}">
@endsection

@section('content')
<div class="qr">
    <h3 class="qr__header">照合用QRコード</h3>
    <div class="qr__wrap">
        {{ $reservation->qrCode('/rep/reservation/' . $reservation->id) }}
    </div>
</div>
@endsection