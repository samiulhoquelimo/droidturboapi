<?php

namespace App\Http\Requests;

class LogoutRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [];
    }
}
