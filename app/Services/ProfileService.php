<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ProfileRepository;

class ProfileService
{
    private ProfileRepository $profileRepository;
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
    private string $defaultProfileImagePath = 'JIRAH/profiles/profile-images/';
    private string $defaultBackgroundImagePath = 'JIRAH/profiles/background-images/jirah-default.gif';
    public function create(User $user)
    {
        $this->defaultProfileImagePath .= "{$user->gender}.png";
        return $this->profileRepository->create($user, $this->defaultProfileImagePath, $this->defaultBackgroundImagePath);
    }
}
