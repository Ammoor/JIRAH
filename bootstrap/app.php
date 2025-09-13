<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use App\Helpers\ApiResponseFormatHelper;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {

            // Error types not listed will be caught by instanceof Exception as 500.

            // dd($e->getMessage(), $e->getCode(), get_class($e)); // To catch unknown exception types in development.

            if ($e instanceof BadRequestHttpException) {
                return ApiResponseFormatHelper::failedResponse(400, $e->getMessage());
            }
            if ($e instanceof AuthenticationException) {
                return ApiResponseFormatHelper::failedResponse(401, $e->getMessage());
            }
            if ($e instanceof RouteNotFoundException) {
                throw new AuthenticationException(); // No Accept: application/json — convert redirect to AuthenticationException.
            }
            if ($e instanceof AccessDeniedHttpException) {
                return ApiResponseFormatHelper::failedResponse(403, $e->getMessage());
            }
            if ($e instanceof NotFoundHttpException) { // Route not found and Model not found use this error.
                return ApiResponseFormatHelper::failedResponse(404, $e->getMessage());
            }
            if ($e instanceof ConflictHttpException) {
                return ApiResponseFormatHelper::failedResponse(409, $e->getMessage());
            }
            if ($e instanceof ValidationException) {
                return ApiResponseFormatHelper::failedResponse(422, $e->errors());
            }
            if ($e instanceof ThrottleRequestsException) {
                return ApiResponseFormatHelper::failedResponse(429, $e->getMessage());
            }
            if ($e instanceof ServiceUnavailableHttpException) {
                return ApiResponseFormatHelper::failedResponse(503, $e->getMessage());
            }
            if ($e instanceof Exception) {

                $code = $e->getCode();
                if (!is_int($code) || $code < 100) {
                    $code = 500;
                }
                if (config('app.debug')) {

                    $message = "Unhandled Exception: " . $e->getMessage() . " Trace: " . $e->getTraceAsString();
                    return ApiResponseFormatHelper::failedResponse($code, $e, $message);
                } else { // Hide unknown exceptions on production.
                    return ApiResponseFormatHelper::failedResponse($code, 'Something went wrong on the server.');
                }
            }
        });
    })->create();
