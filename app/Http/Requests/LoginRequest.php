<?php

namespace App\Http\Requests;

class LoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'    => 'required|max:11',
            'password' => 'required|min:6|max:26',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required'    => 'Phone is required!',
            'phone.max'         => 'Phone length is 11!',
            'password.required' => 'Password is required!',
            'password.min'      => 'Password is too short!',
            'password.max'      => 'Password is too big!',
        ];
    }

    public function filters(): array
    {
        return [
            'phone' => 'trim|escape',
        ];
    }
}
