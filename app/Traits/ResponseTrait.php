<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{

    public function responseSuccess($data = null, $status_code = Response::HTTP_OK, $message = "Successful"): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $status_code);
    }

    public function responseError(
        $message,
        $status_code = Response::HTTP_UNPROCESSABLE_ENTITY,
        $data = null,
        Exception $errors = null
    ): JsonResponse
    {
        if (isset($errors->errorInfo[1]) && $errors->errorInfo[1] == 1062) {
            $message = 'Found Duplicate';
        }
        if (isset($errors->errorInfo[1])) {
            $message = $errors->getMessage();
        }

        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
            'data'    => $data,
        ], $status_code);
    }

}
