<?php

session_start();

require_once __DIR__ . '/../config/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check empty fields
    if ($username === '' || $password === '') {

        $error = 'Please enter your username and password.';

    } else {

        // Find user by username
        $stmt = $pdo->prepare("
            SELECT
                user_id,
                user_username,
                user_password,
                user_role
            FROM users
            WHERE user_username = ?
            LIMIT 1
        ");

        $stmt->execute([$username]);

        $user = $stmt->fetch();

        // Check username and password
        if ($user && password_verify($password, $user['user_password'])) {

            // Store user information in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['user_username'];
            $_SESSION['role'] = $user['user_role'];

            // Log successful login
            if (function_exists('logActivity')) {
                logActivity(
                    $pdo,
                    $_SESSION['user_id'],
                    $_SESSION['username'],
                    'login',
                    'success'
                );
            }

            // Redirect according to role
            if ($user['user_role'] === 'admin') {

                header('Location: ../app/admin/index.php');
                exit;

            } elseif ($user['user_role'] === 'manager') {

                header('Location: ../app/manager/index.php');
                exit;

            } elseif ($user['user_role'] === 'user') {

                header('Location: ../app/user/index.php');
                exit;

            } else {

                // Unknown role
                $error = 'Invalid user role.';

            }

        } else {

            // Login failed
            $error = 'Invalid username or password.';

            // Log failed login
            if (function_exists('logActivity')) {
                logActivity(
                    $pdo,
                    null,
                    $username,
                    'login',
                    'failed'
                );
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign In</title>
</head>

<body>

    <h1>Sign In</h1>

    <?php if ($error !== ''): ?>

        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <p>
            <label for="username">Username:</label>

            <input type="text" id="username" name="username" autocomplete="username" required>
        </p>

        <p>
            <label for="password">Password:</label>

            <input type="password" id="password" name="password" autocomplete="current-password" required>
        </p>

        <button type="submit">
            SIGN IN
        </button>

    </form>

</body>

</html>