<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeininRequest extends FormRequest
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
          'user' => 'required',
          'genre' => 'required',
          'role' => 'required',
          'creater' => 'required',
          'target' => 'required',
          'email' => 'required|email',
          'password' => ['required', 'min:8', 'regex:/[0-9a-z]{8,}/', 'not_regex:/password/', 'not_regex:/.{8,}/'],
        ];
    }

    public function messages()
    {
        return [
          'user.required' => '※ユーザー名を入力して下さい',
          'genre.required' => '※選択して下さい',
          'role.required' => '※選択して下さい',
          'creater.required' => '※選択して下さい',
          'target.required' => '※選択して下さい',
          'email.required' => '※入力して下さい',
          'email.email' => '※メールアドレスを入力して下さい',
          'password.required' => '※入力して下さい',
          'password.min' => '※8文字以上入力して下さい',
          'password.regex' => '※半角英数字のみで入力して下さい',
          'password.not_regex' => '※パスワードが簡単すぎます',
        ];
    }
}
