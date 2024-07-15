<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', Password::default()],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前には、文字を指定してください。',
            'name.max' => 'お名前は、255文字以下にしてください。',
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスには、文字を指定してください。',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'email.max' => 'メールアドレスは、255文字以下にしてください。',
            'email.unique' => '指定のメールアドレスは既に使用されています。',
            'password.required' => 'パスワードを入力してください',
            'password.string' => 'パスワードには、文字を指定してください。',
            'password.min' => 'パスワードは、8文字以上にしてください。',
            'password.max' => 'パスワードは、255文字以下にしてください。',
        ];
    }
}
