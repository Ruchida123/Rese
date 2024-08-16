<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopReviewRequest extends FormRequest
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
            'shop_id' => ['required'],
            'evaluate' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '飲食店情報が登録されていません。',
            'evaluate.required' => '評価を選択してください。',
        ];
    }
}
