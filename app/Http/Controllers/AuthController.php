<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->sendErrorResponse('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        $data = [
            'token' => $token,
            'user' => $user,
        ];

        return $this->sendSuccessResponse('Login successful', $data, Response::HTTP_OK);
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
