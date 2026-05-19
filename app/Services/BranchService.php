<?php

namespace App\Services;

use App\Models\Branch;
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

    public function updateBranch(Branch $branch, array $attributes): bool
    {
        return $this->branchRepository->updateBranch($branch, $attributes);
    }

}
