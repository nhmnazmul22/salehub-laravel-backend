<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OTPVerifyRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Mail\SendOtpMail;
use App\Models\User;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Log;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     */
    public function login(LoginRequest $request)
    {
        try {
            if (auth()->check()) {
                auth()->logout();
            }

            $credentials = $request->validated();;

            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->sendErrorResponse(
                    'Invalid credentials',
                    Response::HTTP_UNAUTHORIZED
                );
            }


            return $this->sendSuccessResponse(
                'Login successful',
                [
                    'token' => $token,
                    'user' => new UserResource(auth()->user()),
                ],
            );
        } catch (Exception $err) {
            Log::error($err);
            return $this->sendErrorResponse('Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get the authenticated user
     */
    public function me()
    {
        return $this->sendSuccessResponse('Profile retrieved successful', new UserResource(auth()->user()));
    }

    /**
     * logout authenticated user
     */
    public function logOut()
    {
        try {
            auth()->logout();
            return $this->sendSuccessResponse('User logged out successful');
        } catch (JWTException $e) {
            return $this->sendErrorResponse('Unable to logout', Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Forgot the password
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        // Check email exist or not
        $existUser = User::where('email', $data['email'])->first();

        // Generate a OTP cache it for 5 min
        $randOTP = rand(100000, 999999);
        Cache::put('password_reset_otp' . $existUser->email, $randOTP, now()->addMinute(5));

        // Send to user email
        Mail::to($existUser->email)->send(new SendOtpMail($randOTP));

        return $this->sendSuccessResponse('A 6 digit OTP send to your email. It will expire within 5 min');

    }

    /**
     * Verify the OTP code
     */

    public function verifyOTP(OTPVerifyRequest $request)
    {
        $validated = $request->validated();

        // Find the user from users table
        $existUser = User::where('email', $validated['email'])->first();

        // Verify the otp with cached otp
        $cachedOtp = Cache::get('password_reset_otp' . $existUser->email);

        if (!$cachedOtp || $cachedOtp !== $validated['otp']) {
            return $this->sendErrorResponse('Invalid OTP');
        }

        // Remove the cached otp
        Cache::forget('password_reset_otp' . $existUser->email);

        // Generate a reset token
        $token = Str::random(60);
        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $existUser->email],
                ['token' => $token, 'created_at' => now()]
            );

        return $this->sendSuccessResponse('OTP verification successful', ['resetToken' => $token]);
    }

    /**
     * Reset The password
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        // Find the user and token
        $existUser = User::where('email', $validated['email'])->first();

        // Check the exist password and new password match or not if not match then send to next process
        if (Hash::check($validated['newPassword'], $existUser->password)) {
            return $this->sendErrorResponse(
                'New password cannot be the same  as the old password',
            );
        }

        $token = DB::table('password_reset_tokens')
            ->where('email', $existUser->email)
            ->where('token', $validated['token']);

        if ($token->doesntExist()) {
            return $this->sendErrorResponse(
                'Unauthorized',
                Response::HTTP_UNAUTHORIZED
            );
        };

        if (Carbon::parse($token->first()->created_at)->diffInMinutes(now()) > 30) {
            return $this->sendErrorResponse('Token expired', Response::HTTP_UNAUTHORIZED);
        }

        $existUser->password = Hash::make($validated['newPassword']);
        $existUser->save();

        // Remove the token
        $token->delete();

        return $this->sendSuccessResponse(
            'Password reset successful',
            ['loginRequired' => true],
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Change password
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Check user old password match or not with user model password
        if (!Hash::check($validated['oldPassword'], $user->password)) {
            return $this->sendErrorResponse('Old Password not match');
        };

        $user->password = Hash::make($validated['newPassword']);
        $user->save();

        // Logout the current user and generate new token
        auth()->logout();
        $newToken = JWTAuth::fromUser($user);

        return $this->sendSuccessResponse('Password changed successful', ['token' => $newToken]);
    }
}
