<?php

namespace App\Services\FoodItemServices;

use App\Repositories\FoodItemRepository;
use App\Helpers\Auth;

/**
 * Service class for creating new food items.
 */
class CreateService
{
    public string $name;
    public string $category;
    public array $iddsiLevels;

    /**
     * Set the name of the food item.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name of the food item.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the category of the food item.
     *
     * @param string $category
     * @return $this
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the category of the food item.
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Set the IDDSI levels for the food item.
     *
     * @param array $iddsiLevels
     * @return $this
     */
    public function setIddsiLevels(array $iddsiLevels): self
    {
        $this->iddsiLevels = array_unique($iddsiLevels);
        
        return $this;
    }

    /**
     * Get the IDDSI levels for the food item.
     *
     * @return array
     */
    public function getIddsiLevels(): array
    {
        return $this->iddsiLevels;
    }

    /**
     * Process the creation of a new food item.
     *
     * @return array
     */
    public function process(): array
    {
        $foodItemRepository = new FoodItemRepository();
        $foodItemRepository->create([
            'name' => $this->getName(),
            'category' => $this->getCategory(),
            'iddsi_levels' => implode(',', $this->getIddsiLevels()),
            'created_by' => Auth::user()['userId'],
        ]);

        return ['success' => true, 'message' => 'Food item created successfully', 'data' => []];
    }
}