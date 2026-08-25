<?php
function logActivity($pdo, $user_id, $email, $action, $status = 'success')
{
    try {
        // Get client IP address
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

        // Fixed: Corrected function name 'strpos' and variable '$ip_address'
        if (strpos($ip_address, ',') !== false) {
            // Fixed: Explode the string first, then trim the first IP entry
            $ip_parts = explode(',', $ip_address);
            $ip_address = trim($ip_parts[0]);
        }

        // Get User Agent 
        $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 255);

        // Query
        $stmt = $pdo->prepare("
            INSERT INTO activity_logs (
                user_id,
                user_email,
                activity_log_action,
                activity_log_status,
                activity_log_ip_address, 
                user_agent
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        // Execute the query
        $success = $stmt->execute([
            $user_id,
            $email,
            $action,
            $status,
            $ip_address,
            $user_agent
        ]);

        // Fixed: Return the boolean result of the execution
        return $success;

    } catch (PDOException $e) {
        error_log("Activity Log Error: " . $e->getMessage());
        return false;
    }
}
?>