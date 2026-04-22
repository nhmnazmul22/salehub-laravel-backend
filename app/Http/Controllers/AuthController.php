<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
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
     * Update the specified resource in storage.
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
     * Display the specified resource.
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        // Check email exist or not
        $existUser = User::where('email', $data['email'])->first();
        if (!$existUser) {
            return $this->sendErrorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        // Generate a OTP cache it for 5 min
        $randOTP = rand(100000, 999999);
        Cache::put('password_reset_otp' . $existUser->email, $randOTP, now()->addMinute(5));

        // Send to user email
        Mail::to($existUser->email)->send(new SendOtpMail($randOTP));

        return $this->sendSuccessResponse('A 6 digit OTP send to your email. It will expire within 5 min');

    }
}
