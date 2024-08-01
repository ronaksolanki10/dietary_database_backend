<?php

namespace App\Services\FoodItemServices;

use App\Repositories\FoodItemRepository;
use App\Repositories\ResidentRepository;
use App\Helpers\Auth;

/**
 * Service class for retrieving consumable food items for a specific resident.
 */
class GetResidentConsumableService
{
    public int $residentId;

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
     * Process the retrieval of consumable food items for the resident.
     *
     * @return array
     */
    public function process(): array
    {
        $foodItemRepository = new FoodItemRepository();
        $residentRepository = new ResidentRepository();

        $resident = $residentRepository->getByIdAndCreatedBy($this->getResidentId(), Auth::user()['userId']);

        if (empty($resident)) {
            return ['success' => false, 'message' => 'Invalid resident selected'];
        }

        $foodItems = $foodItemRepository->getByResidentConsumableAndCreatedBy(
            residentIddsiLevel: $resident['iddsi_level'],
            createdBy: Auth::user()['userId']
        );

        return ['success' => true, 'message' => 'Success', 'data' => $foodItems];
    }
}