<?php

namespace App\Services;

use App\Repository\BranchRepository;
use Illuminate\Database\Eloquent\Collection;

class BranchService extends BaseService
{

    public function __construct(private readonly BranchRepository $branchRepository)
    {

    }

    public function getAllBranch(): Collection
    {
        return $this->branchRepository->getBranches();
    }

    public function createBranch(array $attributes)
    {
        return $this->branchRepository->createBranch($attributes);
    }

}
