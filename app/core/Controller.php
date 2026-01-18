<?php
/**
 * Base Controller Class
 * Loads models and views
 */

class Controller
{
    /**
     * Load model
     */
    protected function model($model)
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    /**
     * Load view
     */
    protected function view($view, $data = [])
    {
        // Check if view file exists
        if (file_exists('../app/views/' . $view . '.php')) {
            // Extract data array to variables
            extract($data);

            // Include view file
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist: ' . $view);
        }
    }

    /**
     * Redirect to another page
     */
    protected function redirect($url)
    {
        header('Location: ' . URL_ROOT . '/' . $url);
        exit();
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if user is admin
     */
    protected function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Require login
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }

    /**
     * Require admin
     */
    protected function requireAdmin()
    {
        if (!$this->isAdmin()) {
            $this->redirect('');
        }
    }

    /**
     * Flash message
     */
    protected function flash($name, $message, $type = 'success')
    {
        $_SESSION['flash_' . $name] = [
            'message' => $message,
            'type' => $type
        ];
    }
}
?>