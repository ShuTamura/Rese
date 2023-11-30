<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeMailRequest extends FormRequest
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
            'title' => 'required|string|max:120',
            'body' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '件名を入力してください',
            'title.string' => '正しく入力してください',
            'title.max' => '文字数が多すぎます',
            'body.required' => 'お知らせ内容を入力してください',
            'body.string' => '正しく入力してください',
            'body.max' => '255文字以内で入力してください',
        ];
    }
}
