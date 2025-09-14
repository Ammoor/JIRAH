<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use App\Http\Requests\VerifyEmailRequest;
use App\Helpers\ApiResponseFormatHelper;

class MailController extends Controller
{
    private MailService $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function verifyEmail(VerifyEmailRequest $request)
    {
        $this->mailService->verifyEmail($request->verification_code);
        return ApiResponseFormatHelper::successResponse(200, 'Email verified successfully.');
    }
    public function sendEmailVerification()
    {
        $this->mailService->sendEmailVerification();
        return ApiResponseFormatHelper::successResponse(200, 'Confirmation email sent.');
    }
}
