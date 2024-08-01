<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

/**
 * Repository for managing food items in the database.
 */
class FoodItemRepository extends BaseRepository
{
    protected $table = 'food_items';

    /**
     * Get all food items created by a specific user.
     *
     * @param int $createdBy
     * @return array
     */
    public function getAllByCreatedBy(int $createdBy): array
    {
        return $this->select(table: $this->table, conditions: "created_by = {$createdBy}");
    }

    /**
     * Get food items consumable by a resident based on their IDDSI level and created by a specific user.
     *
     * @param int $residentIddsiLevel
     * @param int $createdBy
     * @return array
     */
    public function getByResidentConsumableAndCreatedBy(int $residentIddsiLevel, int $createdBy): array
    {
        return $this->select(table: $this->table, conditions: "created_by = {$createdBy} AND FIND_IN_SET({$residentIddsiLevel}, iddsi_levels)");
    }

    /**
     * Get a specific food item by its ID and the creator's ID.
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
     * Search for food items by search terms and creator's ID.
     *
     * @param int $createdBy
     * @param string $search
     * @return array
     */
    public function getAllBySearchAndCreatedBy(int $createdBy, string $search): array
    {
        $conditions = [];
        $searchTerms = explode(',', $search);
        foreach ($searchTerms as $term) {
            $term = $this->mysqli->real_escape_string(trim($term));
            if ($term !== '') {
                $conditions[] = "FIND_IN_SET('$term', iddsi_levels)";
            }
        }
        $iddsiLevelWhereClause = implode(' OR ', $conditions);
        $search = $this->mysqli->real_escape_string($search);

        return $this->select(table: $this->table, conditions: "created_by = {$createdBy} AND (name LIKE '%{$search}%' OR category LIKE '%{$search}%' OR ({$iddsiLevelWhereClause}))");
    }
}