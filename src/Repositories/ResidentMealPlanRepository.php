<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

/**
 * Repository for managing resident meal plans in the database.
 */
class ResidentMealPlanRepository extends BaseRepository
{
    protected $table = 'resident_meal_plans';

    /**
     * Check if a meal plan exists for a resident and a food item.
     *
     * @param int $residentId
     * @param int $foodItemId
     * @return bool
     */
    public function isExistByResidentAndFoodItemId(int $residentId, int $foodItemId): bool
    {
        $result = $this->selectOne(table: $this->table, conditions: "resident_id = {$residentId} AND food_item_id = {$foodItemId}");
        return !empty($result);
    }

    /**
     * Get all meal plans with resident and food item details created by a specific user.
     *
     * @param int $createdBy
     * @return array
     */
    public function getAllWithResidentAndFoodItemDetailsByCreatedBy(int $createdBy): array
    {
        $joinData = [
            [
                'table' => 'residents',
                'foreign_key_column' => 'resident_id',
                'columns' => 'name as resident_name, iddsi_level as resident_iddsi_level'
            ],
            [
                'table' => 'food_items',
                'foreign_key_column' => 'food_item_id',
                'columns' => 'name as food_item_name, iddsi_levels as food_item_iddsi_levels'
            ],
        ];

        return $this->selectWithJoins(table: $this->table, joinData: $joinData, conditions: "{$this->table}.created_by = {$createdBy}");
    }

    /**
     * Search for meal plans with resident and food item details by search term and creator's ID.
     *
     * @param int $createdBy
     * @param string $search
     * @return array
     */
    public function getAllWithResidentAndFoodItemDetailsBySearchAndCreatedBy(int $createdBy, string $search): array
    {
        $joinData = [
            [
                'table' => 'residents',
                'foreign_key_column' => 'resident_id',
                'columns' => 'name as resident_name, iddsi_level as resident_iddsi_level'
            ],
            [
                'table' => 'food_items',
                'foreign_key_column' => 'food_item_id',
                'columns' => 'name as food_item_name, iddsi_levels as food_item_iddsi_levels'
            ],
        ];

        $search = $this->mysqli->real_escape_string($search);

        return $this->selectWithJoins(table: $this->table, joinData: $joinData, conditions: "{$this->table}.created_by = {$createdBy} AND {$this->table}.name LIKE '%{$search}%'");
    }
}