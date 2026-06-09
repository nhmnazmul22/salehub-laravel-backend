<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->userService->getUserList();
        return $this->sendSuccessResponse('Users retrieved successful', UserResource::collection($result));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $result = $this->userService->createNewUser($request->validated());
        return $this->sendSuccessResponse(
            'User created successful',
            new UserResource($result),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->sendSuccessResponse('User retrieved successful', new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $result = $this->userService->updateUser($user, $request->validated());
        return $this->sendSuccessResponse(
            'User updated successful',
            new UserResource($result),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return $this->sendSuccessResponse('User deleted successful', null, Response::HTTP_NO_CONTENT);
    }
}
