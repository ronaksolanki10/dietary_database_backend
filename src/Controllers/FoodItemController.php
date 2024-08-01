<?php

namespace App\Controllers;

use App\Traits\ApiResponse;
use App\Services\FoodItemServices\CreateService;
use App\Services\FoodItemServices\CreateWithUploadService;
use App\Validators\FoodItemValidators\CreateValidator;
use App\Services\FoodItemServices\ListService;
use App\Validators\FoodItemValidators\GetResidentConsumableValidator;
use App\Services\FoodItemServices\GetResidentConsumableService;
use App\Validators\Common\CreateWithUploadValidator;
use App\Helpers\Request;
use App\Helpers\CsvUpload;

/**
 * Controller for managing food items.
 */
class FoodItemController
{
    use ApiResponse;

    /**
     * Store a new food item.
     *
     * @return string JSON response
     */
    public function store(): string
    {
        $validator = new CreateValidator();
        $validation = $validator->doValidation();

        if (!$validation['success']) {
            return $this->apiResponse(
                message: $validation['error'], 
                code: $validation['status']
            );
        }

        $service = new CreateService();
        $response = $service->setName($validation['input']['name'])
                            ->setIddsiLevels($validation['input']['iddsi_levels'])
                            ->setCategory($validation['input']['category'])
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
     * List food items based on search criteria.
     *
     * @return string JSON response
     */
    public function list(): string
    {
        $service = new ListService();
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

    /**
     * Get food items by resident consumable.
     *
     * @return string JSON response
     */
    public function getByResidentConsumable(): string
    {
        $validator = new GetResidentConsumableValidator();
        $validation = $validator->doValidation();

        if (!$validation['success']) {
            return $this->apiResponse(
                message: $validation['error'], 
                code: $validation['status']
            );
        }

        $service = new GetResidentConsumableService();
        $response = $service->setResidentId($validation['input']['resident_id'])
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
     * Create food items with CSV upload.
     *
     * @return string JSON response
     */
    public function createWithUpload(): string
    {
        $validator = new CreateWithUploadValidator();
        $validation = $validator->doValidation();

        if (!$validation['success']) {
            return $this->apiResponse(
                message: $validation['error'], 
                code: $validation['status']
            );
        }

        $csvData = CsvUpload::parse($validation['input']['file']['tmp_name'], ['name', 'category', 'iddsi_levels']);

        if (!$csvData['success']) {
            return $this->apiResponse(
                message: $csvData['message'], 
                code: 400
            );
        }

        $response = ['success' => true, 'message' => 'Data processed successfully', 'data' => []];
        if (!empty($csvData['data'])) {
            $service = new CreateWithUploadService();
            $response = $service->setData($csvData['data'])
                                ->process();
        }

        return $this->apiResponse(
            message: $response['message'],
            data: $response['data']
        );
    }
}