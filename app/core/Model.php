<?php
/**
 * Base Model Class
 * Handles database operations
 */

class Model
{
    protected $db;
    protected $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Prepare SQL statement
     */
    protected function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    /**
     * Execute prepared statement
     */
    protected function execute($stmt, $params = [])
    {
        try {
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Fetch single record
     */
    protected function fetchSingle($stmt)
    {
        return $stmt->fetch();
    }

    /**
     * Fetch all records
     */
    protected function fetchAll($stmt)
    {
        return $stmt->fetchAll();
    }

    /**
     * Get last insert ID
     */
    protected function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    /**
     * Begin transaction
     */
    protected function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    /**
     * Commit transaction
     */
    protected function commit()
    {
        return $this->conn->commit();
    }

    /**
     * Rollback transaction
     */
    protected function rollback()
    {
        return $this->conn->rollBack();
    }
}
?>