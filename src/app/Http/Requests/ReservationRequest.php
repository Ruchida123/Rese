<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Auth;

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
            'shop_id' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
            'number' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '飲食店情報が登録されていません。',
            'date.required' => '予約日付を入力してください。',
            'time.required' => '予約時間を選択してください。',
            'number.required' => '予約人数を選択してください。',
        ];
    }

    public function withValidator(Validator $validator) {
        $validator->after(function ($validator) {
            // ログインしてなければエラー
            if(!Auth::check()){
                $validator->errors()->add('auth', '予約するにはログインが必要です。');
            }
        });
    }
}
