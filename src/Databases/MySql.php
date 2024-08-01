<?php

namespace App\Databases;

/**
 * Singleton MySQL database connection class.
 */
class MySql
{
    private static ?self $instance = null;
    private \mysqli $mysqli;
    private string $host;
    private string $username;
    private string $password;
    private string $dbname;

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_DATABASE'];
        $this->mysqli = new \mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    /**
     * Get the singleton instance of the MySql class.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the MySQLi connection.
     *
     * @return \mysqli
     */
    public function getConnection(): \mysqli
    {
        return $this->mysqli;
    }
}
?>