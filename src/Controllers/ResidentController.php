<?php

namespace App\Controllers;

use App\Traits\ApiResponse;
use App\Services\ResidentServices\CreateService;
use App\Validators\ResidentValidators\CreateValidator;
use App\Services\ResidentServices\ListService;
use App\Helpers\Request;
use App\Helpers\CsvUpload;
use App\Validators\Common\CreateWithUploadValidator;
use App\Services\ResidentServices\CreateWithUploadService;

/**
 * Controller for managing residents.
 */
class ResidentController
{
    use ApiResponse;

    /**
     * Store a new resident.
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
                            ->setIddsiLevel($validation['input']['iddsi_level'])
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
     * List residents based on search criteria.
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
     * Create residents with CSV upload.
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

        $csvData = CsvUpload::parse($validation['input']['file']['tmp_name'], ['name', 'iddsi_level']);

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