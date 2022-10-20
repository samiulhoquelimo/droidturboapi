<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

abstract class BaseRequest extends FormRequest
{
    use SanitizesInput;
    use ResponseTrait;

    public function validateResolved()
    {
        {
            $this->sanitize();
            parent::validateResolved();
        }
    }

    abstract public function rules();

    abstract public function authorize();

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['status' => false, 'message' => $validator->errors()->first()],
            ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        throw new ValidationException($validator, $response);
    }
}
