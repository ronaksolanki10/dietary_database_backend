<?php

namespace App\Services\ResidentServices;

use App\Repositories\ResidentRepository;
use App\Repositories\FoodItemRepository;
use App\Repositories\ResidentMealPlanRepository;
use App\Helpers\Auth;

/**
 * Service class for creating a meal plan for a resident.
 */
class CreateMealPlanService
{
    public string $name;
    public int $residentId;
    public int $foodItemId;

    /**
     * Set the name of the meal plan.
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
     * Get the name of the meal plan.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the resident ID.
     *
     * @param int $residentId
     * @return $this
     */
    public function setResidentId(int $residentId): self
    {
        $this->residentId = $residentId;

        return $this;
    }

    /**
     * Get the resident ID.
     *
     * @return int
     */
    public function getResidentId(): int
    {
        return $this->residentId;
    }

    /**
     * Set the food item ID.
     *
     * @param int $foodItemId
     * @return $this
     */
    public function setFoodItemId(int $foodItemId): self
    {
        $this->foodItemId = $foodItemId;

        return $this;
    }

    /**
     * Get the food item ID.
     *
     * @return int
     */
    public function getFoodItemId(): int
    {
        return $this->foodItemId;
    }

    /**
     * Process the creation of a meal plan for the resident.
     *
     * @return array
     */
    public function process(): array
    {
        $userId = Auth::user()['userId'];
        $residentRepository = new ResidentRepository();
        $resident = $residentRepository->getByIdAndCreatedBy($this->getResidentId(), $userId);

        if (empty($resident)) {
            return ['success' => false, 'message' => 'Invalid resident selected'];
        }

        $foodItemRepository = new FoodItemRepository();
        $foodItem = $foodItemRepository->getByIdAndCreatedBy($this->getFoodItemId(), $userId);

        if (empty($foodItem)) {
            return ['success' => false, 'message' => 'Invalid food item selected'];
        }

        if (!in_array($resident['iddsi_level'], explode(',', $foodItem['iddsi_levels']))) {
            return [
                'success' => false,
                'message' => "'{$foodItem['name']}' food item is not consumable for '{$resident['name']}' resident"
            ];
        }

        $residentMealPlanRepository = new ResidentMealPlanRepository();
        $isMealPlanExists = $residentMealPlanRepository->isExistByResidentAndFoodItemId(
            $this->getResidentId(), 
            $this->getFoodItemId()
        );

        if ($isMealPlanExists) {
            return [
                'success' => false,
                'message' => "Meal plan with food item '{$foodItem['name']}' and resident '{$resident['name']}' already exists"
            ];
        }

        $residentMealPlanRepository->create([
            'name' => $this->getName(),
            'resident_id' => $this->getResidentId(),
            'food_item_id' => $this->getFoodItemId(),
            'created_by' => $userId
        ]);

        return ['success' => true, 'message' => 'Meal plan created successfully', 'data' => []];
    }
}