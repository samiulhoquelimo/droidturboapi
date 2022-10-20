<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterService extends BaseService
{

    /**
     * api: registration
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create($request->storeData($request));
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
