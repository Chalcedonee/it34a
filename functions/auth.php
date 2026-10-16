<?php
function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}

function requireRole($role)
{
    requireLogin();

    $currentRole = $_SESSION['role'] ?? null;

    if ($currentRole !== $role) {
        http_response_code(403);
        exit('Access Denied');
    }
}
