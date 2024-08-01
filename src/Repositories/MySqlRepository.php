<?php

namespace App\Repositories;

use App\Databases\MySql;

/**
 * Abstract repository class for interacting with MySQL database.
 */
class MySqlRepository extends MySql
{
    protected $mysqli;

    public function __construct() {
        $this->mysqli = MySql::getInstance()->getConnection();
    }

    /**
     * Select multiple records from the database.
     *
     * @param string $table
     * @param string $columns
     * @param string $conditions
     * @return array
     */
    protected function select(string $table, string $columns = '*', string $conditions = ''): array
    {
        $sql = "SELECT $columns FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }
        $result = $this->mysqli->query($sql);

        if ($result === false) {
            die("Query failed: " . $this->mysqli->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Select a single record from the database.
     *
     * @param string $table
     * @param string $columns
     * @param string $conditions
     * @return array|null
     */
    protected function selectOne(string $table, string $columns = '*', string $conditions = ''): ?array
    {
        $sql = "SELECT $columns FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions LIMIT 1";
        }
        $result = $this->mysqli->query($sql);

        if ($result === false) {
            die("Query failed: " . $this->mysqli->error);
        }

        return $result->fetch_assoc() ?: null;
    }

    /**
     * Insert a new record into the database.
     *
     * @param string $table
     * @param array $data
     * @return int
     */
    protected function insert(string $table, array $data): int
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $this->mysqli->error);
        }

        $types = str_repeat('s', count($data));
        $stmt->bind_param($types, ...array_values($data));

        $stmt->execute();
        if ($stmt->error) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows;
    }

    /**
     * Update records in the database.
     *
     * @param string $table
     * @param array $data
     * @param string $conditions
     * @return int
     */
    protected function update(string $table, array $data, string $conditions): int
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key = ?, ";
        }
        $set = rtrim($set, ", ");
        $sql = "UPDATE $table SET $set WHERE $conditions";

        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $this->mysqli->error);
        }

        $types = str_repeat('s', count($data));
        $stmt->bind_param($types, ...array_values($data));

        $stmt->execute();
        if ($stmt->error) {
            die("Execute failed: " . $stmt->error);
        }

        return $stmt->affected_rows;
    }

    /**
     * Select records with joins.
     *
     * @param string $table
     * @param array $joinData
     * @param string $columns
     * @param string $conditions
     * @return array
     */
    protected function selectWithJoins(string $table, array $joinData, string $columns = '*', string $conditions = ''): array
    {
        $select = "{$table}.{$columns}";
        $sql = "SELECT ";
        $innerJoin = '';
        if (!empty($joinData)) {
            foreach ($joinData as $join) {
                $columns = explode(',', $join['columns']);
                if (!empty($columns)) {
                    foreach ($columns as $column) {
                        $select .= ", {$join['table']}.$column";
                    }
                }
                $innerJoin .= " INNER JOIN {$join['table']} ON {$join['table']}.id = {$table}.{$join['foreign_key_column']}";
            }
        }
        $sql .= "{$select} FROM {$table} $innerJoin";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }
        $result = $this->mysqli->query($sql);

        if ($result === false) {
            die("Query failed: " . $this->mysqli->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}