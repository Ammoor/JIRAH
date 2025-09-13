<?php

namespace App\Repositories;

use App\Models\User;

class ProfileRepository
{
    public function create(User $user, string $defaultProfileImagePath, $defaultBackgroundImagePath)
    {
        return $user->profile()->create(['profile_image_path' => $defaultProfileImagePath, 'background_image_path' => $defaultBackgroundImagePath]);
    }
    public function show(User $user)
    {
        return $user->profile;
    }
}
