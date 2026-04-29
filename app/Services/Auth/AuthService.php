<?php

namespace App\Services\Auth;

use App\Exceptions\BusinessException;
use App\Exceptions\UnauthorizedException;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Services\BaseService;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    /**
     * Login user
     * @throws UnauthorizedException
     */
    public function loginService(array $attributes): string
    {
        if (auth()->check()) {
            auth()->logout();
        }

        if (!$token = JWTAuth::attempt($attributes)) {
            throw new UnauthorizedException('Invalid credentials');
        }

        return $token;
    }

    public function forgotPasswordService(array $attributes): void
    {
        // Generate an OTP cache it for 5 min
        $randOTP = rand(100000, 999999);
        Cache::put('password_reset_otp' . $attributes['email'], $randOTP, now()->addMinutes(5));

        // Send to user email
        Mail::to($attributes['email'])->send(new SendOtpMail($randOTP));
    }

    /**
     * @throws BusinessException
     */
    public function verifyOTPService(array $attributes): string
    {
        // Verify the otp with cached otp
        $cachedOtp = Cache::get('password_reset_otp' . $attributes['email']);

        if (!$cachedOtp || $cachedOtp !== $attributes['otp']) {
            throw new BusinessException('Invalid OTP');
        }

        // Remove the cached otp
        Cache::forget('password_reset_otp' . $attributes['email']);

        // Generate a reset token
        $token = Str::random(60);
        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $attributes['email']],
                ['token' => $token, 'created_at' => now()]
            );

        return $token;
    }


    /**
     * @throws BusinessException
     * @throws UnauthorizedException
     */
    public function resetPassword(array $attributes): void
    {
        // Find the user and token
        $existUser = User::where('email', $attributes['email'])->first();

        // Check the exist password and new password match or not if not match then send to next process
        if (Hash::check($attributes['newPassword'], $existUser->password)) {
            throw new BusinessException('New password cannot be the same  as the old password');
        }

        $token = DB::table('password_reset_tokens')
            ->where('email', $existUser->email)
            ->where('token', $attributes['token']);

        if ($token->doesntExist()) {
            throw new UnauthorizedException('Invalid token');
        }

        if (Carbon::parse($token->first()->created_at)->diffInMinutes(now()) > 30) {
            throw new UnauthorizedException('Token expired');
        }

        $existUser->password = Hash::make($attributes['newPassword']);
        $existUser->save();

        // Remove the token
        $token->delete();
    }


    /**
     * @throws BusinessException
     */
    public function changePasswordService(array $attributes)
    {
        $user = Auth::user();

        // Check user old password match or not with user model password
        if (!Hash::check($attributes['oldPassword'], $user->password)) {
            throw new BusinessException('Old Password not match');
        }

        $user->password = Hash::make($attributes['newPassword']);
        $user->save();

        // Logout the current user and generate new token
        auth()->logout();
        return JWTAuth::fromUser($user);
    }

}
