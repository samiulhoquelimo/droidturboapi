<?php

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;

class LogoutService extends BaseService
{

    public function logoutFailed($message): JsonResponse
    {
        return $this->responseError($message);
    }

    public function logoutSuccess(): JsonResponse
    {
        return $this->responseSuccess(message: 'Successfully logged out');
    }
}
