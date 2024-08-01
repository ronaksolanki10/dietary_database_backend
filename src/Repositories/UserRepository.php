<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

/**
 * Repository for managing users in the database.
 */
class UserRepository extends BaseRepository
{
    protected $table = 'users';

    /**
     * Get a user by their username and password.
     *
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function getUserByUsernamePassword(string $username, string $password): ?array
    {
        $conditions = "username = '{$username}' AND password = '{$password}'";
        $result = $this->select(table: $this->table, columns: 'id,username', conditions: $conditions);

        return $result ? $result[0] : null;
    }
}