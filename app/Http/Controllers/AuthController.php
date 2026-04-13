<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Log;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Response;
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
    public function logOut(Request $request, string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function resetPassword(string $id)
    {
        //
    }
}
