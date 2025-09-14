<?php

namespace App\Services;

use App\Mail\UserEmailConfirmationMail;
use App\Repositories\PendingMailVerificationRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;

class MailService
{
    private PendingMailVerificationRepository $pendingMailVerificationRepository;
    private int $verificationCodeExpireAfter = 10; // In minutes.
    public function __construct(PendingMailVerificationRepository $pendingMailVerificationRepository)
    {
        $this->pendingMailVerificationRepository = $pendingMailVerificationRepository;
    }
    private function generateRandomCode()
    {
        return (string) random_int(100000, 999999);
    }
    public function sendEmailVerification()
    {
        $user = auth()->user();
        if (Gate::allows('is_user_verified')) {
            throw new BadRequestHttpException('Email is already verified. No verification code sent.');
        }
        $pendingData['verification_code'] = $this->generateRandomCode();
        $pendingData['expires_at'] = now()->addMinutes($this->verificationCodeExpireAfter);
        $this->pendingMailVerificationRepository->updateOrCreate($user, $pendingData);
        $user = $user->toArray();
        return Mail::to($user['email'])->send(
            new UserEmailConfirmationMail($user, $pendingData['verification_code'], $this->verificationCodeExpireAfter)
        );
    }
    public function verifyEmail(int $verification_code)
    {
        $user = auth()->user();
        $isUserVerified = $this->pendingMailVerificationRepository->get($user, $verification_code);
        if ($isUserVerified) {
            $this->pendingMailVerificationRepository->delete($user);
            return $user->update(['is_email_verified' => true]);
        }
        throw ValidationException::withMessages(['verification_code' => 'Invalid or expired code.']);
    }
}
