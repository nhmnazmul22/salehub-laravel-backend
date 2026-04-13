<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{
    protected function sendSuccessResponse(string $message = 'Data Retrieved successful', mixed $data = null, int $status = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function sendErrorResponse(string $message, int $status = Response::HTTP_BAD_REQUEST, mixed $error = null)
    {
        return response()->json([
            'successful' => false,
            'message' => $message,
            'error' => $error,
        ], $status);
    }
}
