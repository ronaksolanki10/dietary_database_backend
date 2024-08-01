<?php

namespace App\Services\ResidentServices;

use App\Repositories\ResidentMealPlanRepository;
use App\Helpers\Auth;

/**
 * Service class for listing resident meal plans.
 */
class ListMealPlanService
{
    public ?string $search = null;

    /**
     * Set the search term for filtering meal plans.
     *
     * @param string|null $search
     * @return $this
     */
    public function setSearch(?string $search): self
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get the search term used for filtering meal plans.
     *
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * Process the retrieval of resident meal plans with optional search term.
     *
     * @return array
     */
    public function process(): array
    {
        $residentMealPlanRepository = new ResidentMealPlanRepository();
        $search = $this->getSearch();
        $userId = Auth::user()['userId'];

        if (!empty($search)) {
            $response = $residentMealPlanRepository->getAllWithResidentAndFoodItemDetailsBySearchAndCreatedBy($userId, $search);
        } else {
            $response = $residentMealPlanRepository->getAllWithResidentAndFoodItemDetailsByCreatedBy($userId);
        }

        return ['success' => true, 'message' => 'success', 'data' => $response];
    }
}