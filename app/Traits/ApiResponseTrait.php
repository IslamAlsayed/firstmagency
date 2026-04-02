<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function successResponse(mixed $data, string $message = '', int $status = 200): JsonResponse
    {
        $response = ['success' => true, 'data' => $data];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }

    protected function paginatedResponse(mixed $paginator, callable $transform): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $paginator->getCollection()->map($transform)->values(),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }

    protected function errorResponse(string $message, int $status = 400): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }

    protected function notFoundResponse(string $message = 'Resource not found.'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }
}
