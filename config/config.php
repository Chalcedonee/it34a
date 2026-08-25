<?php
session_start();

// Include required function files before executing logActivity()
require_once __DIR__ . '/../includes/activity-logger.php';

define('BASE_URL', 'http://localhost/it34a');

define('DB_HOST', 'localhost');
define('DB_NAME', 'it34a_lab_db');
define('DB_USER', 'root');
define('DB_PASS', '');

$user_id = "root";
$user_email = "root";

try {
    // Fixed: Used parentheses () instead of curly braces {}
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Fixed: Corrected string formatting and added $ to success
    $success = logActivity($pdo, $user_id, $user_email, 'db_connect_success');

    // Fixed: Added $ prefix for variable checking
    if ($success) {
        echo "Activity logged successfully.";
    } else {
        echo "Failed to log activity.";
    }

    // Fixed: Corrected spelling to PDOException
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
