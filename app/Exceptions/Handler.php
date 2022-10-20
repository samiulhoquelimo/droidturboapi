<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (AuthenticationException $e) {
            return response()->json([
                'status'      => false,
                'message'     => 'Unauthenticated.',
                'errors'      => $e,
                'status_code' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        });
    }

    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return new JsonResponse(['status' => false, 'message' => $exception->errors()],
            ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|ResponseAlias|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status'      => false,
                'message'     => 'Unauthenticated.',
                'errors'      => $exception->getMessage(),
                'status_code' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
        return redirect()->guest(route('/'));
    }
}
