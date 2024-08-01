<?php

namespace App\Traits;

/**
 * Trait ApiResponse
 *
 * Provides a method to return standardized API responses.
 */
trait ApiResponse
{
    /**
     * Send a JSON response with a standardized format.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return void
     */
    public function apiResponse(string $message = '', array $data = [], int $code = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($code);

        echo json_encode([
            'success' => $code === 200,
            'message' => $message,
            'data' => $data
        ]);

        exit;
    }
}