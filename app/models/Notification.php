<?php
/**
 * Notification Model
 * Handles notification operations
 */

class Notification extends Model
{

    /**
     * Create new notification
     */
    public function create($data)
    {
        $sql = "INSERT INTO notifications (user_id, title, message) 
                VALUES (:user_id, :title, :message)";

        $stmt = $this->prepare($sql);

        $params = [
            ':user_id' => $data['user_id'],
            ':title' => $data['title'],
            ':message' => $data['message']
        ];

        if ($this->execute($stmt, $params)) {
            return $this->lastInsertId();
        }

        return false;
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications($user_id, $limit = null)
    {
        $sql = "SELECT * FROM notifications 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC";

        if ($limit) {
            $sql .= " LIMIT " . (int) $limit;
        }

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':user_id' => $user_id]);

        return $this->fetchAll($stmt);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount($user_id)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM notifications 
                WHERE user_id = :user_id AND is_read = 'no'";

        $stmt = $this->prepare($sql);
        $this->execute($stmt, [':user_id' => $user_id]);

        $result = $this->fetchSingle($stmt);
        return $result['count'];
    }

    /**
     * Mark as read
     */
    public function markAsRead($notification_id)
    {
        $sql = "UPDATE notifications 
                SET is_read = 'yes' 
                WHERE notification_id = :notification_id";

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, [':notification_id' => $notification_id]);
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead($user_id)
    {
        $sql = "UPDATE notifications 
                SET is_read = 'yes' 
                WHERE user_id = :user_id";

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, [':user_id' => $user_id]);
    }

    /**
     * Delete notification
     */
    public function delete($notification_id)
    {
        $sql = "DELETE FROM notifications WHERE notification_id = :notification_id";

        $stmt = $this->prepare($sql);
        return $this->execute($stmt, [':notification_id' => $notification_id]);
    }
}
?>