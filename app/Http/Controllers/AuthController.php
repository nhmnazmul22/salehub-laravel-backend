<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OTPVerifyRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{

    public function __construct(protected AuthService $authService)
    {

    }

    /**
     * Store a newly created resource in storage.
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request)
    {
        $token = $this->authService->loginService($request->validated());
        return $this->sendSuccessResponse(
            'Login successful',
            [
                'token' => $token,
                'user' => new UserResource(auth()->user()),
            ],
        );
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
        } catch (Exception) {
            return $this->sendErrorResponse('Unable to logout', Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Forgot the password
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->authService->forgotPasswordService($request->validated());
        return $this->sendSuccessResponse('A 6 digit OTP send to your email. It will expire within 5 min');
    }

    /**
     * Verify the OTP code
     * @throws BusinessException
     */

    public function verifyOTP(OTPVerifyRequest $request)
    {
        $resetToken = $this->authService->verifyOTPService($request->validated());
        return $this->sendSuccessResponse('OTP verification successful', ['resetToken' => $resetToken]);
    }

    /**
     * Reset The password
     * @throws BusinessException
     * @throws UnauthorizedException
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword($request->validated());

        return $this->sendSuccessResponse(
            'Password reset successful',
            ['loginRequired' => true],
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Change password
     * @throws BusinessException
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $newToken = $this->authService->changePasswordService($request->validated());
        return $this->sendSuccessResponse('Password changed successful', ['token' => $newToken]);
    }

    /**
     * Refresh token
     * @throws JWTException
     */

    public function refreshToken()
    {
        $newAccessToken = JWTAuth::parseToken()->refresh();

        return $this->sendSuccessResponse(
            'Token refresh successful',
            [
                'accessToken' => $newAccessToken,
                'expiresIn' => config('jwt.ttl')
            ]
        );
    }

}
