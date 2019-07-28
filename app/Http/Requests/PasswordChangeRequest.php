<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class PasswordChangeRequest extends FormRequest
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
        $hashed_password = Auth::guard('geinin')->user()->password;
        return [
          'current_email' => 'required',
          'current_password' => 'required',
          'new_password' => ['required', 'min:8', 'regex:/[0-9a-z]{8,}/', 'not_regex:/password/', 'not_regex:/.{8,}/'],
        ];
    }

    public function messages()
    {
        return [
          'current_email.required' => '※入力して下さい',
          'current_password.required' => '※入力して下さい',
          'new_password.required' => '※入力して下さい',
          'new_password.min' => '※8文字以上入力して下さい',
          'new_password.regex' => '※半角英数字のみで入力して下さい',
          'new_password.not_regex' => '※パスワードが簡単すぎます',
        ];
    }
}
