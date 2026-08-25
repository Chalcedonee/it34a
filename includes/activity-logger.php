<?php

function logActivity($pdo, $user_id, $email, $action, $status = 'success')
{
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 255);

    $sql = "
        INSERT INTO activity_logs (
            user_id,
            user_email,
            activity_log_action,
            activity_log_status,
            activity_log_ip_address,
            activity_log_user_agent
        ) VALUES (
            :user_id,
            :user_email,
            :action,
            :status,
            :ip_address,
            :user_agent
        )
    ";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':user_id'    => $user_id,
            ':user_email' => $email,
            ':action'     => $action,
            ':status'     => $status,
            ':ip_address' => $ip_address,
            ':user_agent' => $user_agent
        ]);

        return true;

    } catch (PDOException $e) {

        echo '<h2>DATABASE ERROR</h2>';
        echo '<pre>';
        echo htmlspecialchars($e->getMessage());
        echo '</pre>';

        return false;
    }
}
