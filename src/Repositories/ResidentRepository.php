<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

/**
 * Repository for managing residents in the database.
 */
class ResidentRepository extends BaseRepository
{
    protected $table = 'residents';

    /**
     * Get all residents created by a specific user.
     *
     * @param int $createdBy
     * @return array
     */
    public function getAllByCreatedBy(int $createdBy): array
    {
        return $this->select(table: $this->table, conditions: "created_by = {$createdBy}");
    }

    /**
     * Get a specific resident by its ID and the creator's ID.
     *
     * @param int $id
     * @param int $createdBy
     * @return array|null
     */
    public function getByIdAndCreatedBy(int $id, int $createdBy): ?array
    {
        $result = $this->select(table: $this->table, conditions: "id = {$id} AND created_by = {$createdBy}");
        return $result ? $result[0] : null;
    }

    /**
     * Search for residents by search terms and creator's ID.
     *
     * @param int $createdBy
     * @param string $search
     * @return array
     */
    public function getAllBySearchAndCreatedBy(int $createdBy, string $search): array
    {
        $search = $this->mysqli->real_escape_string($search);
        return $this->select(table: $this->table, conditions: "created_by = {$createdBy} AND (name LIKE '%{$search}%' OR iddsi_level LIKE '%{$search}%')");
    }
}