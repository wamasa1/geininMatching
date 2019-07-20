<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class AccountDeleteRequest extends FormRequest
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
        // $hashed_password = Auth::guard('geinin')->user()->password;
        return [
          'current_email_del' => 'required',
          'current_password_del' => 'required',
        ];
    }

    public function messages()
    {
        return [
          'current_email_del.required' => '※入力して下さい',
          'current_password_del.required' => '※入力して下さい',
        ];
    }
}
