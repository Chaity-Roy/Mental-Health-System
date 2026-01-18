<?php
/**
 * Resource Model
 * Handles mental health resources
 */

class Resource extends Model
{

    /**
     * Create new resource
     */
    public function create($data)
    {
        $sql = "INSERT INTO resources (title, content, category, created_by, status) 
                VALUES (:title, :content, :category, :created_by, :status)";

        $stmt = $this->prepare($sql);

        $params = [
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':category' => $data['category'],
            ':created_by' => $data['created_by'],
            ':status' => $data['status']
        ];

        if ($this->execute($stmt, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }

    /**
     * Get all published resources
     */
    public function getPublished($limit = null)
    {
        $sql = "SELECT r.*, u.full_name as author 
                FROM resources r 
                LEFT JOIN users u ON r.created_by = u.user_id 
                WHERE r.status = 'published' 
                ORDER BY r.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int) $limit;
        }

        $stmt = $this->prepare($sql);
        $this->execute($stmt);

        return $this->fetchAll($stmt);
    }

    /**
     * Get all resources (admin)
     */
    public function getAll($limit = null)
    {
        $sql = "SELECT r.*, u.full_name as author 
                FROM resources r 
                LEFT JOIN users u ON r.created_by = u.user_id 
                ORDER BY r.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int) $limit;
        }

        $stmt = $this->prepare($sql);
        $this->execute($stmt);

        return $this->fetchAll($stmt);
    }

    /**
     * Get resource by ID
     */
    public function getById($resource_id)
    {
        $sql = "SELECT r.*, u.full_name as author 
                FROM resources r 
                LEFT JOIN users u ON r.created_by = u.user_id 
                WHERE r.resource_id = :resource_id";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':resource_id' => $resource_id]);

        return $this->fetchSingle($stmt);
    }

    /**
     * Update resource
     */
    public function update($resource_id, $data)
    {
        $sql = "UPDATE resources 
                SET title = :title, content = :content, category = :category, status = :status 
                WHERE resource_id = :resource_id";

        $stmt = $this->prepare($sql);

        $params = [
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':category' => $data['category'],
            ':status' => $data['status'],
            ':resource_id' => $resource_id
        ];

        return $this->execute($stmt, $params);
    }

    /**
     * Delete resource
     */
    public function delete($resource_id)
    {
        $sql = "DELETE FROM resources WHERE resource_id = :resource_id";

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, [':resource_id' => $resource_id]);
    }

    /**
     * Get resource count
     */
    public function getCount($status = null)
    {
        if ($status) {
            $sql = "SELECT COUNT(*) as count FROM resources WHERE status = :status";
            $stmt = $this->prepare($sql);
            $this->execute($stmt, [':status' => $status]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM resources";
            $stmt = $this->prepare($sql);
            $this->execute($stmt);
        }

        $result = $this->fetchSingle($stmt);
        return $result['count'];
    }
}
?>