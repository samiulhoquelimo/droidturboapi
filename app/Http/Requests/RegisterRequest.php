<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function storeData($request): array
    {
        return [
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => $request->password,
            'created_by' => auth()->id(),
            'created_at' => Carbon::now()
        ];
    }

    public function rules(): array
    {
        return [
            'name'     => 'required',
            'phone'    => 'required|max:11|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required!',
            'email.required'    => 'Email is required!',
            'email.email'       => 'Invalid Email!',
            'email.unique'      => 'Already registered. Try with different Email!',
            'phone.required'    => 'Phone is required!',
            'phone.unique'      => 'The phone has already been taken!',
            'phone.max'         => 'Phone length should be 11',
            'password.required' => 'Password is required!',
            'password.min'      => 'Password is too short!',
        ];
    }

    public function filters(): array
    {
        return [
            'phone' => 'trim|escape',
            'email' => 'trim|escape',
        ];
    }
}
