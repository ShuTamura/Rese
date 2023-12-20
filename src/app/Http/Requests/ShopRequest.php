<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'area_id' => 'required',
            'genre_id' => 'required',
            'detail' => 'required|string|max:400',
            'image' => 'file|mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '正しく入力してください',
            'name.max' => '文字数が多すぎます',
            'area_id.required' => '地域を入力してください',
            'genre_id.required' => 'ジャンルを入力してください',
            'detail.required' => 'お店の詳細を入力してください',
            'detail.string' => '正しく入力してください',
            'detail.max' => '400文字以内で入力してください',
            'image.mimes' => '非対応の拡張子です。jpeg、pngのみアップロード可能です',
        ];
    }
}
