<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * API Response Formatter Trait
 * Standardize semua API responses
 */
trait ApiResponse
{
    /**
     * Success response
     */
    public function successResponse($data = null, $message = 'Success', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => now(),
        ], $code);
    }

    /**
     * Created response
     */
    public function createdResponse($data, $message = 'Resource created successfully'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Error response
     */
    public function errorResponse($message = 'Error', $errors = null, $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now(),
        ], $code);
    }

    /**
     * Not found response
     */
    public function notFoundResponse($message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, null, 404);
    }

    /**
     * Unauthorized response
     */
    public function unauthorizedResponse($message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, null, 401);
    }

    /**
     * Forbidden response
     */
    public function forbiddenResponse($message = 'Access forbidden'): JsonResponse
    {
        return $this->errorResponse($message, null, 403);
    }

    /**
     * Validation error response
     */
    public function validationErrorResponse($errors): JsonResponse
    {
        return $this->errorResponse('Validation failed', $errors, 422);
    }

    /**
     * Server error response
     */
    public function serverErrorResponse($message = 'Internal server error'): JsonResponse
    {
        return $this->errorResponse($message, null, 500);
    }
}
