<?php

namespace App\Repository;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user)
    {
    }

    public function createUser(array $attributes): User
    {
        return $this->user->create($attributes);
    }

}
