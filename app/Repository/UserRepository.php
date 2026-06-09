<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user)
    {
    }

    public function findAllUsers(): array|Collection
    {
        return $this->user->where('isActive', true)->get();
    }

    public function createUser(array $attributes): User
    {
        return $this->user->create($attributes);
    }

}
