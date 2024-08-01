<?php

namespace App\Services\ResidentServices;

use App\Repositories\ResidentRepository;
use App\Helpers\Auth;

/**
 * Service class for listing residents.
 */
class ListService
{
    private ?string $search = null;

    /**
     * Set the search term for filtering residents.
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
     * Get the search term used for filtering residents.
     *
     * @return string|null
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * Process the retrieval of residents based on the search term (optional).
     *
     * @return array
     */
    public function process(): array
    {
        $residentRepository = new ResidentRepository();
        $search = $this->getSearch();
        $userId = Auth::user()['userId'];

        if (!empty($search)) {
            $response = $residentRepository->getAllBySearchAndCreatedBy($userId, $search);
        } else {
            $response = $residentRepository->getAllByCreatedBy($userId);
        }

        return ['success' => true, 'message' => 'success', 'data' => $response];
    }
}