<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\BranchStoreRequest;
use App\Http\Requests\Branch\BranchUpdateRequest;
use App\Http\Resources\Branch\BranchResource;
use App\Models\Branch;
use App\Services\BranchService;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends BaseController
{

    public function __construct(private readonly BranchService $branchService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->branchService->getAllBranch();
        return $this->sendSuccessResponse('Branch retrieved successful', BranchResource::collection($result));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchStoreRequest $request)
    {
        $result = $this->branchService->createBranch($request->validated());
        return $this->sendSuccessResponse('Branch created successful', new BranchResource($result), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return $this->sendSuccessResponse(
            'Branch retrieved successful',
            new BranchResource($branch),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Branch $branch, BranchUpdateRequest $request)
    {
        $result = $this->branchService->updateBranch($branch, $request->validated());
        return $this->sendSuccessResponse(
            'Branch updated successful',
            new BranchResource($result),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return $this->sendSuccessResponse('Branch Deleted successful', status: Response::HTTP_NO_CONTENT);
    }
}
