<?php

namespace App\Repositories;

/**
 * Base repository providing common database operations.
 */
class BaseRepository extends MySqlRepository
{
    /**
     * Insert a new record into the repository's table.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        return $this->insert($this->table, $data);
    }
}