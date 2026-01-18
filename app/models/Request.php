<?php
/**
 * Request Model
 * Handles counseling request operations
 */

class Request extends Model
{

    /**
     * Create new request
     */
    public function create($data)
    {
        $sql = "INSERT INTO requests (user_id, subject, description, is_anonymous, status) 
                VALUES (:user_id, :subject, :description, :is_anonymous, 'pending')";

        $stmt = $this->prepare($sql);

        $params = [
            ':user_id' => $data['is_anonymous'] === 'yes' ? null : $data['user_id'],
            ':subject' => $data['subject'],
            ':description' => $data['description'],
            ':is_anonymous' => $data['is_anonymous']
        ];

        if ($this->execute($stmt, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }

    /**
     * Get user requests
     */
    public function getUserRequests($user_id, $limit = null)
    {
        $sql = "SELECT * FROM requests WHERE user_id = :user_id 
                ORDER BY created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int) $limit;
        }

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':user_id' => $user_id]);

        return $this->fetchAll($stmt);
    }

    /**
     * Get request by ID
     */
    public function getById($request_id)
    {
        $sql = "SELECT r.*, u.full_name, u.email 
                FROM requests r 
                LEFT JOIN users u ON r.user_id = u.user_id 
                WHERE r.request_id = :request_id";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':request_id' => $request_id]);

        return $this->fetchSingle($stmt);
    }

    /**
     * Get all requests (admin)
     */
    public function getAllRequests($status = null, $limit = null)
    {
        if ($status) {
            $sql = "SELECT r.*, u.full_name, u.email 
                    FROM requests r 
                    LEFT JOIN users u ON r.user_id = u.user_id 
                    WHERE r.status = :status 
                    ORDER BY r.created_at DESC";

            if ($limit) {
                $sql .= " LIMIT " . (int) $limit;
            }

            $stmt = $this->prepare($sql);
            $this->execute($stmt, [':status' => $status]);
        } else {
            $sql = "SELECT r.*, u.full_name, u.email 
                    FROM requests r 
                    LEFT JOIN users u ON r.user_id = u.user_id 
                    ORDER BY r.created_at DESC";

            if ($limit) {
                $sql .= " LIMIT " . (int) $limit;
            }

            $stmt = $this->prepare($sql);
            $this->execute($stmt);
        }

        return $this->fetchAll($stmt);
    }

    /**
     * Update request status
     */
    public function updateStatus($request_id, $status, $admin_response = null)
    {
        if ($admin_response) {
            $sql = "UPDATE requests 
                    SET status = :status, admin_response = :admin_response 
                    WHERE request_id = :request_id";

            $params = [
                ':status' => $status,
                ':admin_response' => $admin_response,
                ':request_id' => $request_id
            ];
        } else {
            $sql = "UPDATE requests 
                    SET status = :status 
                    WHERE request_id = :request_id";

            $params = [
                ':status' => $status,
                ':request_id' => $request_id
            ];
        }

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, $params);
    }

    /**
     * Get user request statistics
     */
    public function getUserRequestStats($user_id)
    {
        $sql = "SELECT 
                    COUNT(*) as total_requests,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_requests,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_requests,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_requests,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_requests
                FROM requests WHERE user_id = :user_id";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':user_id' => $user_id]);

        return $this->fetchSingle($stmt);
    }

    /**
     * Get overall request statistics
     */
    public function getRequestStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total_requests,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_requests,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_requests,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_requests,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_requests
                FROM requests";

        $stmt = $this->prepare($sql);
        $this->execute($stmt);

        return $this->fetchSingle($stmt);
    }

    /**
     * Delete request
     */
    public function delete($request_id)
    {
        $sql = "DELETE FROM requests WHERE request_id = :request_id";

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, [':request_id' => $request_id]);
    }
}
?>