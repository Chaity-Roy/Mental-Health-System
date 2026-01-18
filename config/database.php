<?php
/**
 * Database Configuration
 * Mental Health Management System
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mental_health_db');

/**
 * Database Connection Class
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $conn;
    private $error;

    /**
     * Create database connection
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Establish database connection
     */
    private function connect()
    {
        $this->conn = null;

        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            );

            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die('Database Connection Error: ' . $this->error);
        }
    }

    /**
     * Get database connection
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Close database connection
     */
    public function closeConnection()
    {
        $this->conn = null;
    }
}
?>