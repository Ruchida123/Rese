<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepresentRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'id' => ['sometimes', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください。',
            'name.string' => '店舗名には、文字を指定してください。',
            'name.max' => '店舗名は、255文字以下にしてください。',
            'id.required' => '店舗情報が存在しません。',
        ];
    }
}
