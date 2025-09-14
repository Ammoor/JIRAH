<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\IsUserVerified;

Route::middleware(ApiKeyMiddleware::class)->group(function () {

    Route::controller(UserController::class)->group(function () {

        Route::post('signin',  'signin');

        Route::post('signup',  'signup');
    });

    Route::middleware('auth:sanctum')->group(function () {

        Route::middleware(IsUserVerified::class)->group(function () {

            Route::controller(UserController::class)->group(function () {

                Route::post('logout', 'logout');
            });

            Route::controller(ProfileController::class)->group(function () {

                Route::get('profile', 'getProfile');
            });
        });

        Route::controller(MailController::class)->group(function () {

            Route::post('emails/verify', 'verifyEmail');

            Route::post('emails/send-verification', 'sendEmailVerification')->middleware('throttle:1,1'); // 1 request per minute.
        });
    });
});
