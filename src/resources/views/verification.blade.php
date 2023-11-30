@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verification.css') }}">
@endsection

@section('content')
<div class="verification">
    <h3 class="verification__header">{{ $reservation->shop->name }}</h3>
    <table class="verification-table" border="1">
            <tr>
                <th><span>予約者</span></th>
                <th><span>予約日</span></th>
                <th><span>時間</span></th>
                <th><span>人数</span></th>
            </tr>
            <tr>
                <td>
                    {{ $reservation->user->name }}
                </td>
                <td>
                    {{ $reservation->date }}
                </td>
                <td>
                    {{ $reservation->time }}
                </td>
                <td>{{ $reservation->number }}</td>
            </tr>
        </table>
</div>
@endsection