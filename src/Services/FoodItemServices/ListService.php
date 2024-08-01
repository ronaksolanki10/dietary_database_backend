<?php

namespace App\Services\FoodItemServices;

use App\Repositories\FoodItemRepository;
use App\Helpers\Auth;

/**
 * Service class for listing food items, with optional search functionality.
 */
class ListService
{
    public ?string $search = null;

    /**
     * Set the search term.
     *
     * @param ?string $search
     * @return $this
     */
    public function setSearch(?string $search): self
    {
        $this->search = $search;
        return $this;
    }

    /**
     * Get the search term.
     *
     * @return ?string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * Process the retrieval of food items, optionally filtered by the search term.
     *
     * @return array
     */
    public function process(): array
    {
        $foodItemRepository = new FoodItemRepository();
        $search = $this->getSearch();
        $userId = Auth::user()['userId'];

        if (!empty($search)) {
            $response = $foodItemRepository->getAllBySearchAndCreatedBy($userId, $search);
        } else {
            $response = $foodItemRepository->getAllByCreatedBy($userId);
        }

        return ['success' => true, 'message' => 'Success', 'data' => $response];
    }
}