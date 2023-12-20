<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'title' => 'required|max:100',
            'score' => 'required',
            'comment' => 'max:400',
            'image' => 'file|mimes:jpg,jpeg,png'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルを入力してください',
            'title.max' => 'タイトルの文字数は100文字までです',
            'score.required' => 'お店を評価してください',
            'comment.max' => '400文字までです',
            'image.mimes' => '非対応の拡張子です。jpeg、pngのみアップロード可能です'
        ];
    }
}
