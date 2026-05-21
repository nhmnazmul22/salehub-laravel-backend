<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    public function render($request, \Throwable $e): JsonResponse|Response
    {

        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof ModelNotFoundException) {

            $model = class_basename($e->getModel());

            return response()->json([
                'success' => false,
                'message' => "{$model} not found",
            ], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?? 'The requested resource could not be found.',
            ], Response::HTTP_NOT_FOUND);
        }


        return parent::render($request, $e);
    }

}
