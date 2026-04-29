<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage() ?? "Business Exception"
        ], $this->getCode() ?? Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
