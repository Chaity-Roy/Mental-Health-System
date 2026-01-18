<?php
/**
 * Feedback Model
 * Handles user feedback operations
 */

class Feedback extends Model
{

    /**
     * Create new feedback
     */
    public function create($data)
    {
        $sql = "INSERT INTO feedback (user_id, message) 
                VALUES (:user_id, :message)";

        $stmt = $this->prepare($sql);

        $params = [
            ':user_id' => isset($data['user_id']) ? $data['user_id'] : null,
            ':message' => $data['message']
        ];

        if ($this->execute($stmt, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }

    /**
     * Get all feedback (admin)
     */
    public function getAll($limit = null)
    {
        $sql = "SELECT f.*, u.full_name, u.email 
                FROM feedback f 
                LEFT JOIN users u ON f.user_id = u.user_id 
                ORDER BY f.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int) $limit;
        }

        $stmt = $this->prepare($sql);
        $this->execute($stmt);

        return $this->fetchAll($stmt);
    }

    /**
     * Get feedback by ID
     */
    public function getById($feedback_id)
    {
        $sql = "SELECT f.*, u.full_name, u.email 
                FROM feedback f 
                LEFT JOIN users u ON f.user_id = u.user_id 
                WHERE f.feedback_id = :feedback_id";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':feedback_id' => $feedback_id]);

        return $this->fetchSingle($stmt);
    }

    /**
     * Get feedback count
     */
    public function getCount()
    {
        $sql = "SELECT COUNT(*) as count FROM feedback";

        $stmt = $this->prepare($sql);
        $this->execute($stmt);

        $result = $this->fetchSingle($stmt);
        return $result['count'];
    }

    /**
     * Delete feedback
     */
    public function delete($feedback_id)
    {
        $sql = "DELETE FROM feedback WHERE feedback_id = :feedback_id";

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, [':feedback_id' => $feedback_id]);
    }
}
?>