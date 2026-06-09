<?php

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService extends BaseService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function getUserList(): Collection|array
    {
        return $this->userRepository->findAllUsers();
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

    /**
     * Update user
     */

    public function updateUser(User $user, array $attributes): User
    {
        $data = array_filter($attributes, fn($value) => $value !== null);
        return $this->userRepository->updateUser($user, $data);
    }

    public function deleteUser(User $user): ?bool
    {
        return $user->delete();
    }
}
