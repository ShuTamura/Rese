<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvContentRequest extends FormRequest
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
            'name.*' => 'required|max:50',
            'area.*' => 'required',
            'genre.*' => 'required',
            'detail.*' => 'required|max:400',
            'image.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => '名前を入力してください',
            'name.*.max' => '文字数が多すぎます',
            'area.*.required' => '地域を入力してください',
            'genre.*.required' => 'ジャンルを入力してください',
            'detail.*.required' => 'お店の詳細を入力してください',
            'detail.*.max' => '400文字以内で入力してください',
            'image.*.required' => '画像のURLを記入してください'
        ];
    }
}
