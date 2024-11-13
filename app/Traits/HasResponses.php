<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HasResponses
{
    public function success($message = null, $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'statusCode' => $statusCode,
        ], $statusCode);
    }

    public function error($message = null, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'statusCode' => $statusCode,
        ], $statusCode);
    }
}


