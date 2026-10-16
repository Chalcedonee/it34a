<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
function hasActiveUserSession(PDO $pdo, int $user_id): bool
{
    $stmt = $pdo->prepare("
        SELECT session_id
        FROM user_sessions
        WHERE user_id = ?
          AND session_end IS NULL
        LIMIT 1
    ");

    $stmt->execute([$user_id]);

    return (bool) $stmt->fetchColumn();
}

//Record session start in the database and return the session ID
function startUserSession(PDO $pdo): int
{
    $stmt = $pdo->prepare("
        INSERT INTO user_sessions (user_id, session_start)
        VALUES (?, NOW())
    ");

    $stmt->execute([$_SESSION['user_id']]);

    return (int) $pdo->lastInsertId();
}

//End the user session in the database
function endUserSession(PDO $pdo): void
{
    if (
        empty($_SESSION['session_id']) ||
        empty($_SESSION['user_id'])
    ) {
        return;
    }

    $stmt = $pdo->prepare("
        UPDATE user_sessions
        SET
            session_end = NOW(),
            session_duration = TIMESTAMPDIFF(
                SECOND,
                session_start,
                NOW()
            )
        WHERE session_id = ?
          AND user_id = ?
          AND session_end IS NULL
    ");

    $stmt->execute([
        $_SESSION['session_id'],
        $_SESSION['user_id']
    ]);
}
