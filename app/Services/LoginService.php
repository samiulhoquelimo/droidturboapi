<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class LoginService extends BaseService
{

    /**
     * api: login
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::query()->where('phone', $request->phone)->firstOrFail();
            $token = $user->createToken('DroidTurbo')->accessToken;

            $cred = $request->only(["phone", "password"]);
            if (auth()->attempt($cred)) {
                return $this->responseSuccess([
                    'user'  => new UserResource($user),
                    'token' => $token
                ]);
            } else {
                return $this->responseError(message: 'Invalid credentials. Please try again.');
            }
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
