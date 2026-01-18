<?php
/**
 * Auth Controller
 * Handles authentication and authorization
 */

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /**
     * Show login page
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->isLoggedIn()) {
            if ($this->isAdmin()) {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('user/dashboard');
            }
            return;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Validate inputs
            $errors = [];

            if (empty($email)) {
                $errors['email'] = 'Email is required';
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required';
            }

            if (empty($errors)) {
                // Attempt login
                $user = $this->userModel->login($email, $password);

                if ($user) {
                    // Create session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        $this->redirect('admin/dashboard');
                    } else {
                        $this->redirect('user/dashboard');
                    }
                } else {
                    $errors['login'] = 'Invalid email or password';
                }
            }

            $data = [
                'email' => $email,
                'errors' => $errors
            ];
        } else {
            $data = [
                'email' => '',
                'errors' => []
            ];
        }

        $this->view('auth/login', $data);
    }

    /**
     * Show registration page
     */
    public function register()
    {
        // Redirect if already logged in
        if ($this->isLoggedIn()) {
            $this->redirect('user/dashboard');
            return;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            // Validate inputs
            $errors = [];

            if (empty($full_name)) {
                $errors['full_name'] = 'Full name is required';
            }

            if (empty($email)) {
                $errors['email'] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors['email'] = 'Email already exists';
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }

            if ($password !== $confirm_password) {
                $errors['confirm_password'] = 'Passwords do not match';
            }

            if (empty($errors)) {
                // Register user
                $data = [
                    'full_name' => $full_name,
                    'email' => $email,
                    'password' => $password,
                    'role' => 'user'
                ];

                if ($this->userModel->register($data)) {
                    $this->flash('register_success', 'Registration successful! Please login.', 'success');
                    $this->redirect('auth/login');
                } else {
                    $errors['register'] = 'Something went wrong. Please try again.';
                }
            }

            $data = [
                'full_name' => $full_name,
                'email' => $email,
                'errors' => $errors
            ];
        } else {
            $data = [
                'full_name' => '',
                'email' => '',
                'errors' => []
            ];
        }

        $this->view('auth/register', $data);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        // Destroy session
        session_unset();
        session_destroy();

        $this->redirect('');
    }
}
?>