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
            'evaluate' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['max:400'],
            'image' => ['mimes:jpeg,jpg,png']
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '飲食店情報が登録されていません。',
            'evaluate.required' => '評価を選択してください。',
            'evaluate.integer' => '評価は整数を指定してください',
            'evaluate.min' => '評価には1以上の数値を指定してください',
            'evaluate.max' => '評価には5以下の数値を指定してください',
            'comment.max' => '口コミは400文字以内で記入してください',
            'image.mimes' => 'jpeg、png以外の拡張子は指定できません',
        ];
    }
}
