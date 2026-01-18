<?php
// Lightweight shim to ensure a Database class is available to the app
// If a Database class is defined in config/database.php, include it.
if (!class_exists('Database')) {
    $configDb = __DIR__ . '/../../config/database.php';
    if (file_exists($configDb)) {
        require_once $configDb;
    } else {
        // Minimal fallback implementation if config/database.php is missing
        class Database
        {
            private $conn;

            public function __construct()
            {
                // no-op: user should configure config/database.php
            }

            public function getConnection()
            {
                return $this->conn;
            }
        }
    }
}

?>
