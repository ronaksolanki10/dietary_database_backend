<?php

namespace App\Services\ResidentServices;

use App\Repositories\ResidentRepository;
use App\Helpers\Auth;

/**
 * Service class for creating a resident.
 */
class CreateService
{
    public string $name;
    public int $iddsiLevel;

    /**
     * Set the name of the resident.
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
     * Get the name of the resident.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the IDDSI level of the resident.
     *
     * @param int $iddsiLevel
     * @return $this
     */
    public function setIddsiLevel(int $iddsiLevel): self
    {
        $this->iddsiLevel = $iddsiLevel;

        return $this;
    }

    /**
     * Get the IDDSI level of the resident.
     *
     * @return int
     */
    public function getIddsiLevel(): int
    {
        return $this->iddsiLevel;
    }

    /**
     * Process the creation of a resident.
     *
     * @return array
     */
    public function process(): array
    {
        $residentRepository = new ResidentRepository();
        $residentRepository->create([
            'name' => $this->getName(),
            'iddsi_level' => $this->getIddsiLevel(),
            'created_by' => Auth::user()['userId'],
        ]);

        return ['success' => true, 'message' => 'Resident created successfully', 'data' => []];
    }
}