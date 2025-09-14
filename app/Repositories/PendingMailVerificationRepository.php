<?php

namespace App\Repositories;

use App\Models\User;

class PendingMailVerificationRepository
{
    public function updateOrCreate(User $user, array $pendingData)
    {
        return $user->PendingMailVerification()->updateOrCreate(
            ['user_id' => $user->id],
            $pendingData
        );
    }
    public function get(User $user, int $verificationCode)
    {
        return $user->PendingMailVerification()->where('verification_code', $verificationCode)->where('expires_at', '>=', now())->exists();
    }
    public function delete(User $user)
    {
        return $user->PendingMailVerification()->delete();
    }
}
