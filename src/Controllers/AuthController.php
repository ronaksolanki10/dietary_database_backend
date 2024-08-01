<?php

namespace App\Controllers;

use App\Services\AuthServices\LoginService;
use App\Validators\AuthValidators\LoginValidator;
use App\Traits\ApiResponse;

/**
 * Controller for handling authentication related actions.
 */
class AuthController
{
    use ApiResponse;

    /**
     * Handle user login.
     *
     * @return string JSON response
     */
    public function login(): string
    {
        $validator = new LoginValidator();
        $validation = $validator->doValidation();

        if (!$validation['success']) {
            return $this->apiResponse(
                message: $validation['error'], 
                code: $validation['status']
            );
        }

        $service = new LoginService();
        $response = $service->setUsername($validation['input']['username'])
                            ->setPassword($validation['input']['password'])
                            ->process();

        if (!$response['success']) {
            return $this->apiResponse(
                message: $response['message'], 
                code: 400
            );
        }

        return $this->apiResponse(
            message: $response['message'],
            data: $response['data']
        );
    }
}