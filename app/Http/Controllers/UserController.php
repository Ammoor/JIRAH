<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSignInRequest;
use App\Http\Requests\UserSignUpRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Helpers\ApiResponseFormatHelper;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function signup(UserSignUpRequest $request)
    {
        $response = $this->userService->signup($request->validated());
        return ApiResponseFormatHelper::successResponse(201, 'User created successfully.', new UserResource($response['user']), ['user_token' => $response['userToken']]);
    }
    public function signin(UserSignInRequest $request)
    {
        $response = $this->userService->checkUserData($request->validated());
        return ApiResponseFormatHelper::successResponse(200, 'User logged in successfully.', new UserResource($response['user']), ['user_token' => $response['userToken']]);
    }
    public function logout()
    {
        $this->userService->logout();
        return ApiResponseFormatHelper::successResponse(200, 'User logged out successfully.');
    }
}
