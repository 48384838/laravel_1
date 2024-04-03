<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
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
            'title' => 'required|max:100', //入力必須｜最大１００文字
            'due_date' => 'required|date|after_or_equal:today', //入力必須｜date(日付表す値)｜after_or_equal(特定の日付と同じまたは、それ以降の日付)
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    public function messages()
    {
        return [
            //キーでメッセージが表示されるべきルールを指定する。
            //ドット区切りで左が項目、右側がルールを意味する。
            'due_date.after_or_equal' => ':attribute には今日以降に日付を入力してください。'
        ];
    }
}
