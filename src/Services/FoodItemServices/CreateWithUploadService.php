<?php

namespace App\Services\FoodItemServices;

use App\Repositories\FoodItemRepository;
use App\Services\FoodItemServices\CreateService;
use App\Helpers\Auth;

/**
 * Service class for creating food items with bulk upload functionality.
 */
class CreateWithUploadService
{
    public array $data;

    /**
     * Set the data for food items.
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
     * Get the data for food items.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Process the creation of food items from the provided data.
     *
     * @return array
     */
    public function process(): array
    {
        $service = new CreateService();
        foreach ($this->getData() as $data) {
            $iddsiLevels = explode(',', $data['iddsi_levels']);
            if (!in_array($data['category'], explode(',', $_ENV['FOOD_CATEGORIES'])) || array_diff($iddsiLevels, explode(',', $_ENV['IDDSI_LEVELS']))) {
                continue;
            }
            $service->setName($data['name'])
                ->setCategory($data['category'])
                ->setIddsiLevels($iddsiLevels)
                ->process();
        }

        return ['success' => true, 'message' => 'Food items uploaded successfully', 'data' => []];
    }
}