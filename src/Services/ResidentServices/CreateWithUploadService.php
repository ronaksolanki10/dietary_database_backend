<?php

namespace App\Services\ResidentServices;

use App\Services\ResidentServices\CreateService;
use App\Helpers\Auth;

/**
 * Service class for creating residents with data upload.
 */
class CreateWithUploadService
{
    public array $data;

    /**
     * Set the data for resident creation.
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get the data for resident creation.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Process the creation of residents from uploaded data.
     *
     * @return array
     */
    public function process(): array
    {
        $service = new CreateService();
        foreach ($this->getData() as $data) {
            if (!in_array($data['iddsi_level'], explode(',', $_ENV['IDDSI_LEVELS']))) {
                continue;
            }
            $service->setName($data['name'])
                ->setIddsiLevel($data['iddsi_level'])
                ->process();
        }

        return ['success' => true, 'message' => 'Residents uploaded successfully', 'data' => []];
    }
}