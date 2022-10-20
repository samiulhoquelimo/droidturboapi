<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\LoginService;
use App\Services\LogoutService;
use App\Services\RegisterService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{

    /**
     * api: register
     * @param RegisterRequest $request
     * @param RegisterService $service
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, RegisterService $service): JsonResponse
    {
        return $service->register($request);
    }

    /**
     * api: login
     * @param LoginRequest $request
     * @param LoginService $service
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginService $service): JsonResponse
    {
        return $service->login($request);
    }

    /**
     * api: logout
     * @param Request $request
     * @param LogoutService $service
     * @return JsonResponse
     */
    public function logout(Request $request, LogoutService $service): JsonResponse
    {
        try {
            if (Auth::check()) {
                $request->user()->token()->revoke();
                return $service->logoutSuccess();
            } else {
                return $service->logoutFailed('Unauthenticated');
            }
        } catch (Exception $e) {
            return $service->logoutFailed($e->getMessage());
        }
    }
}
