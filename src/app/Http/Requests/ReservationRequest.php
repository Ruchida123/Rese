<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;
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
            'date' => ['required', 'date'],
            'time' => ['required'],
            'number' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'shop_id.required' => '飲食店情報が登録されていません。',
            'date.required' => '予約日付を入力してください。',
            'date.date' => '予約日付を日付形式で入力してください。',
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

            $data = $validator->getData();
            // 日付チェック
            $inputDate = new Carbon($data['date']);
            $today = Carbon::today('Asia/Tokyo');
            if ($inputDate < $today) {
                $validator->errors()->add('date', '予約日付には本日以降の日付を入力してください。');
            };
            // 時間チェック
            $time = $data['time'];
            if (!preg_match('/(0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(00|30)$/', $time)) {
                $validator->errors()->add('time', '予約時間は00:00~23:30の30分単位で入力してください。');
            };
            // 人数チェック
            if (filter_var($data['number'], FILTER_VALIDATE_INT)) {
                $number = intval($data['number']);
                if ($number < 1 || 100 < $number) {
                    $validator->errors()->add('number', '予約人数は1~100の数値で入力してください。');
                }
            } else {
                $validator->errors()->add('number', '予約人数は整数で入力してください。');
            };
        });
    }
}
