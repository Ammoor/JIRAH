<?php

namespace App\Services;

use Carbon\Carbon;
use App\Services\ProfileService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserService
{
    private UserRepository $userRepository;
    private ProfileService $profileService;
    public function __construct(UserRepository $userRepository, ProfileService $profileService)
    {
        $this->userRepository = $userRepository;
        $this->profileService = $profileService;
    }
    private function checkAgeEligibility(string $birthDate)
    {
        $minimumAge = 13; // Means the minimum user age that can be join to the system. In years.
        $birthDate = Carbon::createFromFormat('Y-m-d', $birthDate);
        if ($birthDate->age < $minimumAge) {
            throw ValidationException::withMessages(['birth_date' => "User must be at least {$minimumAge} years old."]);
        }
    }
    public function signup(array $userData)
    {
        return DB::transaction(function () use ($userData) {

            $this->checkAgeEligibility($userData['birth_date']);
            $userData['password'] = Hash::make($userData['password']);
            $userData['user_name'] = $userData['first_name'] . '.' . $userData['last_name'] . '.' . time();
            $user = $this->userRepository->create($userData);
            $this->profileService->create($user);
            $userToken = $user->createToken('user_token')->plainTextToken;
            return [
                'user' => $user,
                'userToken' => $userToken,
            ];
        });
    }
    public function checkUserData(array $userData)
    {
        $user = auth()->attempt(['email' => $userData['email'], 'password' => $userData['password']]) ? auth()->user() : null;
        if (!$user) {
            throw new NotFoundHttpException('User credentials does not match DB records.');
        }
        if (!Gate::allows('is_user_verified')) {
            throw new AccessDeniedHttpException('Access denied: user\'s account not verified.');
        }
        $userToken = $user->createToken('user_token')->plainTextToken;
        return [
            'user' => $user,
            'userToken' => $userToken,
        ];
    }
    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}
