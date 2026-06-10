<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryWithChildrenResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $categoryService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->categoryService->getCategoryList();
        return $this->sendSuccessResponse(
            'Category retrieved successfully',
            CategoryWithChildrenResource::collection($result)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $result = $this->categoryService->createNewCategory($request->validated());
        return $this->sendSuccessResponse(
            'Category successfully created',
            new CategoryResource($result),
            Response::HTTP_CREATED
        );
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
