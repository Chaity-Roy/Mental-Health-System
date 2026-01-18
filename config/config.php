<?php
/**
 * Application Configuration
 * Mental Health Management System
 */

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define application constants
define('APP_NAME', 'Mental Health Management System');
define('APP_VERSION', '1.0.0');
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', '/mental-health-system');
define('URL_SUBFOLDER', '/mental-health-system');

// Security settings
define('HASH_COST', 10);
define('SESSION_TIMEOUT', 1800); // 30 minutes

// Pagination settings
define('RECORDS_PER_PAGE', 10);

// File upload settings
define('MAX_FILE_SIZE', 5242880); // 5MB
define('UPLOAD_PATH', APP_ROOT . '/public/uploads/');

// Time zone
date_default_timezone_set('Asia/Kolkata');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once APP_ROOT . '/config/database.php';

/**
 * Auto-load classes
 */
spl_autoload_register(function ($className) {
    $paths = [
        APP_ROOT . '/app/controllers/' . $className . '.php',
        APP_ROOT . '/app/models/' . $className . '.php',
        APP_ROOT . '/app/helpers/' . $className . '.php'
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
?>