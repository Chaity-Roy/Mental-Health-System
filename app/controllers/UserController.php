<?php
/**
 * User Controller
 * Handles user dashboard and profile operations
 */

class UserController extends Controller
{
    private $userModel;
    private $requestModel;
    private $notificationModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->requestModel = $this->model('Request');
        $this->notificationModel = $this->model('Notification');
    }

    /**
     * User Dashboard
     */
    public function dashboard()
    {
        $this->requireLogin();

        if ($this->isAdmin()) {
            $this->redirect('admin/dashboard');
            return;
        }

        $user_id = $_SESSION['user_id'];

        // Get user statistics
        $stats = $this->requestModel->getUserRequestStats($user_id);
        $recentRequests = $this->requestModel->getUserRequests($user_id, 5);
        $unreadNotifications = $this->notificationModel->getUnreadCount($user_id);

        $data = [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentRequests' => $recentRequests,
            'unreadNotifications' => $unreadNotifications
        ];

        $this->view('user/dashboard', $data);
    }

    /**
     * User Profile
     */
    public function profile()
    {
        $this->requireLogin();

        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->findById($user_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = trim($_POST['full_name']);
            $email = trim($_POST['email']);

            $errors = [];

            if (empty($full_name)) {
                $errors['full_name'] = 'Full name is required';
            }

            if (empty($email)) {
                $errors['email'] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format';
            } else {
                $existingUser = $this->userModel->findByEmail($email);
                if ($existingUser && $existingUser['user_id'] != $user_id) {
                    $errors['email'] = 'Email already exists';
                }
            }

            if (empty($errors)) {
                $updateData = [
                    'full_name' => $full_name,
                    'email' => $email
                ];

                if ($this->userModel->updateProfile($user_id, $updateData)) {
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['email'] = $email;
                    $this->flash('profile_success', 'Profile updated successfully', 'success');
                    $this->redirect('user/profile');
                } else {
                    $errors['update'] = 'Failed to update profile';
                }
            }

            $data = [
                'title' => 'Profile',
                'user' => array_merge($user, ['full_name' => $full_name, 'email' => $email]),
                'errors' => $errors
            ];
        } else {
            $data = [
                'title' => 'Profile',
                'user' => $user,
                'errors' => []
            ];
        }

        $this->view('user/profile', $data);
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            $errors = [];
            $user_id = $_SESSION['user_id'];
            $user = $this->userModel->findById($user_id);

            if (empty($current_password)) {
                $errors['current_password'] = 'Current password is required';
            } elseif (!password_verify($current_password, $user['password_hash'])) {
                $errors['current_password'] = 'Current password is incorrect';
            }

            if (empty($new_password)) {
                $errors['new_password'] = 'New password is required';
            } elseif (strlen($new_password) < 6) {
                $errors['new_password'] = 'Password must be at least 6 characters';
            }

            if ($new_password !== $confirm_password) {
                $errors['confirm_password'] = 'Passwords do not match';
            }

            if (empty($errors)) {
                if ($this->userModel->changePassword($user_id, $new_password)) {
                    $this->flash('password_success', 'Password changed successfully', 'success');
                    $this->redirect('user/profile');
                } else {
                    $errors['update'] = 'Failed to change password';
                }
            }

            echo json_encode(['success' => empty($errors), 'errors' => $errors]);
            exit;
        }
    }
}
?>