<?php

namespace App\Repository;


use App\Models\Branch;
use Illuminate\Database\Eloquent\Collection;

class BranchRepository extends BaseRepository
{
    public function __construct(protected Branch $branch)
    {
    }

    public function getBranches(): Collection
    {
        return $this->branch->where('isActive', true)->get();
    }

    public function createBranch(array $attributes)
    {
        return $this->branch->create($attributes);
    }

    public function updateBranch(Branch $branch, array $attributes): bool
    {
        return $branch->update($attributes);
    }


}
