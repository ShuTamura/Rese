@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/csv_content.css') }}">
@endsection

@section('content')
<div class="csv-content">
    <form action="/admin/csv/add" class="csv-content-form" method="POST">
        @csrf
        <button class="csv-content-form__btn">店舗情報を追加する</button>
        <table class="csv-content__table" border="1">
            <tr>
                <th>name</th>
                <th>area</th>
                <th>genre</th>
                <th>detail</th>
                <th>image</th>
            </tr>
            @foreach($params as $param)
            <tr>
                <td><input name="name[]" class="csv-content-form__input" type="text" value="{{ $param['name'] }}"></td>
                <td><input name="area[]" class="csv-content-form__input" type="text" value="{{ $param['area'] }}"></td>
                <td><input name="genre[]" class="csv-content-form__input" type="text" value="{{ $param['genre'] }}"></td>
                <td><input name="detail[]" class="csv-content-form__input" type="text" value="{{ $param['detail'] }}"></td>
                <td><input name="image[]" class="csv-content-form__input" type="text" value="{{ $param['image'] }}"></td>
            </tr>
            @endforeach
        </table>
    </form>
</div>
@endsection