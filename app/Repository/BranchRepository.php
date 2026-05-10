<?php

namespace App\Repository;


use App\Models\Branch;

class BranchRepository extends BaseRepository
{
    public function __construct(protected Branch $branch)
    {
    }

    public function createBranch(array $attributes)
    {
        return $this->branch->create($attributes);
    }


}
