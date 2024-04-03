<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
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
            'title' => 'required|max:20',
        ];
    }

    //入力欄の名称をカスタマイズ。attributeメソッドが入力欄の名称を定義。
    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }
}
