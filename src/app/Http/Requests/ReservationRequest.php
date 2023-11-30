<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'date' => 'required|date|after:today',
            'time' => 'required|date_format:H:i',
            'number' => 'required|integer|max:16'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '来店日を入力してください',
            'date.date' => '正しく入力してください',
            'date.after' => '翌日以降の日付を選択してください',
            'time.required' => '来店時間を入力してください',
            'time.date_format' => '正しく入力してください',
            'number.required' => '人数を選択してください',
            'number.integer' => '数字を入力してください',
            'number.max' => '一度の予約人数は16人までです',
        ];
    }
}
