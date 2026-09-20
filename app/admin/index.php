<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/functions.php';

requireRole('admin');

logActivity(
    $pdo,
    $_SESSION['user_id'],
    $_SESSION['user_email'],
    'view_activity_logs',
);

    #Query get all activity logs
    $stmt = $pdo->prepare("
        SELECT *
        FROM activity_logs
        ORDER BY activity_log_timestamp DESC
    ");
    
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Hello Admin</h1>
    <a href="../auth/signout.php">Sign out</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>Action</th>
                <th>Status</th>
                <th>Ip Address</th>
                <th>User Agent</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php?>
        </tbody>
    </table>

</body>
</html>