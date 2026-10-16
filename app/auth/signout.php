<?php

require_once __DIR__ . '/../../config/config.php';

// Get current user information before clearing the session
$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? 'unknown';

// Log the logout before destroying the session
if (isset($pdo) && function_exists('logActivity')) {
    logActivity(
        $pdo,
        $user_id,
        $username,
        'logout',
        'success'
    );
}

// Clear session data
$_SESSION = [];

// Destroy the session
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Return to the login page
header('Location: ../../index.php');
exit;
