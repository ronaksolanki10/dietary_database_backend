<?php

namespace App\Helpers;

/**
 * Class Request
 * Provides methods to handle HTTP request data.
 */
class Request
{
    /**
     * Retrieve and parse the POST data from the request.
     *
     * @return array|null
     */
    public static function post(): ?array
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if (!empty($postData)) {
            return $postData;
        }

        return array_merge($_POST, $_FILES);
    }

    /**
     * Retrieve query parameters from the URL.
     *
     * @return array
     */
    public static function queryParams(): array
    {
        return $_GET;
    }
}