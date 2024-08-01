<?php

namespace App\Middlewares;

use App\Traits\ApiResponse;
use App\Helpers\Auth as AuthHelper;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

/**
 * Class Auth
 * Middleware for handling authentication.
 */
class Auth implements IMiddleware
{
    use ApiResponse;

    /**
     * Handle the incoming request and check for authentication.
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void
    {
        $authHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']) : '';
        
        if (!empty($authHeader)) {
            $response = AuthHelper::validateToken($authHeader);
            AuthHelper::setUser($authHeader);

            if (!$response) {
                $this->apiResponse(
                    code: 401,
                    message: 'Unauthorized, Please login to continue'
                );
            }
        } else {
            $this->apiResponse(
                code: 401,
                message: 'Unauthorized, Please login to continue'
            );
        }
    }
}