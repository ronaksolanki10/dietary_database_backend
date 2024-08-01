<?php

namespace App\Controllers;

use App\Traits\ApiResponse;
use App\Services\ResidentServices\CreateMealPlanService;
use App\Validators\ResidentValidators\CreateMealPlanValidator;
use App\Services\ResidentServices\ListMealPlanService;
use App\Helpers\Request;

/**
 * Controller for managing resident meal plans.
 */
class ResidentMealPlanController
{
    use ApiResponse;

    /**
     * Store a new resident meal plan.
     *
     * @return string JSON response
     */
    public function store(): string
    {
        $validator = new CreateMealPlanValidator();
        $validation = $validator->doValidation();

        if (!$validation['success']) {
            return $this->apiResponse(
                message: $validation['error'],
                code: $validation['status']
            );
        }

        $service = new CreateMealPlanService();
        $response = $service->setResidentId($validation['input']['resident_id'])
                            ->setName($validation['input']['name'])
                            ->setFoodItemId($validation['input']['food_item_id'])
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

    /**
     * List resident meal plans based on search criteria.
     *
     * @return string JSON response
     */
    public function list(): string
    {
        $service = new ListMealPlanService();
        $response = $service->setSearch(Request::queryParams()['search'] ?? null)
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