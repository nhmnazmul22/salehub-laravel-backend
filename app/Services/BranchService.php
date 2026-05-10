<?php

namespace App\Services;

use App\Repository\BranchRepository;

class BranchService extends BaseService
{

    public function __construct(private readonly BranchRepository $branchRepository)
    {

    }

    public function createBranch(array $attributes)
    {
        return $this->branchRepository->createBranch($attributes);
    }

}
