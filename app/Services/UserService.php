<?php

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepository;

class UserService extends BaseService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }


    /**
     * Create new user
     */

    public function createNewUser(array $attributes): User
    {
        $data = [
            'firstName' => $attributes['firstName'],
            'lastName' => $attributes['lastName'],
            'role' => $attributes['role'] ?? 'staff',
            'email' => $attributes['email'],
            'password' => $attributes['password'],
            'branchId' => $attributes['branchId'],
        ];
        return $this->userRepository->createUser($data);
    }
}
