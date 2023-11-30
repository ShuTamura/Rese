<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|string|max:255',
            'password' => 'required|min:8|max:255'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しく入力してください',
            'email.string' => '正しく入力してください',
            'email.max' => '文字数が多すぎます',
            'password.required' => 'パスワードを入力してください',
            'password.max' => '文字数が多すぎます',
            'password.min' => 'パスワードは８文字以上で入力してください',
        ];
    }
}
