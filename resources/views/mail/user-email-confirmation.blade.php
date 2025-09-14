<x-mail.main>
    <x-slot:emailTitle>
        Email Verification
    </x-slot:emailTitle>
    <x-slot:headerMessage>
        Welcome to {{ config('app.name') }}!
    </x-slot:headerMessage>
    <x-slot:content>
        <!-- Content -->
        <div style="margin-bottom: 30px;">
            <p style="font-size: 16px; margin-bottom: 15px;">Dear {{ $userData['first_name'] }},</p>

            <p style="font-size: 16px; margin-bottom: 15px;">Welcome to <strong>{{ config('app.name') }}</strong> – where
                your experience is
                our priority. We're excited to have you join our community!</p>

            <p style="font-size: 16px; margin-bottom: 20px;">To complete your registration and secure your account,
                please verify your email address using the verification code below:</p>
        </div>

        <!-- Verification Code -->
        <div
            style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 25px; text-align: center; border-radius: 8px; margin: 25px 0;">
            <p style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Your Verification Code</p>
            <div style="font-size: 32px; font-weight: bold; letter-spacing: 4px; font-family: 'Courier New', monospace;">
                {{ $verificationCode }}
            </div>
        </div>

        <!-- Important Information -->
        <div
            style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid #007bff; margin: 25px 0;">
            <h3 style="color: #007bff; margin: 0 0 15px 0; font-size: 18px;">Important Information:</h3>
            <ul style="margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">This verification code is valid for
                    <strong>{{ $verificationCodeExpireAfter }} minutes</strong>
                </li>
                <li style="margin-bottom: 8px;">Please do not share this code with anyone</li>
                <li style="margin-bottom: 0;">If you didn't create an account with us, please ignore this email</li>
            </ul>
        </div>

        <!-- Support -->
        <p style="font-size: 16px; margin: 25px 0 15px 0;">If you have any questions or need assistance, please don't
            hesitate to contact our support team.</p>

        <p style="font-size: 16px; margin: 25px 0;">
            Best regards,<br>
            <strong style="color: #007bff;">The {{ config('app.name') }} Team</strong>
        </p>
    </x-slot:content>
</x-mail.main>
