<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\BranchStoreRequest;
use App\Services\BranchService;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchStoreRequest $request)
    {
        $result = $this->branchService->createBranch($request->validated());
        return $this->sendSuccessResponse('Branch created successful', $result, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
