<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Http\Resources\ProfileResource;
use App\Helpers\ApiResponseFormatHelper;

class ProfileController extends Controller
{
    private ProfileService $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    public function getProfile()
    {
        $profile = $this->profileService->show();
        return ApiResponseFormatHelper::successResponse(200, 'Profile Data returned successfully.', new ProfileResource($profile));
    }
}
