<?php
/**
 * User Model
 * Handles user-related database operations
 */

class User extends Model
{

    /**
     * Register new user
     */
    public function register($data)
    {
        $sql = "INSERT INTO users (full_name, email, password_hash, role) 
                VALUES (:full_name, :email, :password_hash, :role)";

        $stmt = $this->prepare($sql);

        // Hash password
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $params = [
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':password_hash' => $password_hash,
            ':role' => isset($data['role']) ? $data['role'] : 'user'
        ];

        if ($this->execute($stmt, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }

    /**
     * Login user
     */
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND status = 'active'";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':email' => $email]);

        $user = $this->fetchSingle($stmt);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }

    /**
     * Find user by email
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':email' => $email]);

        return $this->fetchSingle($stmt);
    }

    /**
     * Find user by ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = :id";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':id' => $id]);

        return $this->fetchSingle($stmt);
    }

    /**
     * Get all users (for admin)
     */
    public function getAllUsers($role = null)
    {
        if ($role) {
            $sql = "SELECT user_id, full_name, email, role, status, created_at 
                    FROM users WHERE role = :role ORDER BY created_at DESC";
            $stmt = $this->prepare($sql);
            $this->execute($stmt, [':role' => $role]);
        } else {
            $sql = "SELECT user_id, full_name, email, role, status, created_at 
                    FROM users ORDER BY created_at DESC";
            $stmt = $this->prepare($sql);
            $this->execute($stmt);
        }

        return $this->fetchAll($stmt);
    }

    /**
     * Update user status
     */
    public function updateStatus($user_id, $status)
    {
        $sql = "UPDATE users SET status = :status WHERE user_id = :user_id";

        $stmt = $this->prepare($sql);

        return $this->execute($stmt, [
            ':status' => $status,
            ':user_id' => $user_id
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile($user_id, $data)
    {
        $sql = "UPDATE users SET full_name = :full_name, email = :email 
                WHERE user_id = :user_id";

        $stmt = $this->prepare($sql);

        return $this->execute($stmt, [
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':user_id' => $user_id
        ]);
    }

    /**
     * Change password
     */
    public function changePassword($user_id, $new_password)
    {
        $sql = "UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id";

        $stmt = $this->prepare($sql);
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        return $this->execute($stmt, [
            ':password_hash' => $password_hash,
            ':user_id' => $user_id
        ]);
    }

    /**
     * Get user statistics
     */
    public function getUserStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total_users,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_users,
                    SUM(CASE WHEN status = 'blocked' THEN 1 ELSE 0 END) as blocked_users
                FROM users WHERE role = 'user'";

        $stmt = $this->prepare($sql);
        $this->execute($stmt);

        return $this->fetchSingle($stmt);
    }
}
?>