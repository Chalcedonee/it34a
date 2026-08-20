<?php
function logActivity($pdo,$user_id,$email,$action, $status='success'){
    try{
        // Get client ip address
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

        // String to Array
        if (strpos($ip,',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        };

        //Get User Agent (Browser)
        $user_agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 255);

        // Query
        $stmt = $pdo->prepare("
            INSERT INTO activity_logs(
                user_id,
                user_email,
                activity_log_action,
                activity_log_status,
                activity_log_ip_address, 
                user_agent
            ) VALUES (?,?,?,?,?,?)
         ");

    } catch (PDOException $e) {
        error_log("Activity Log Error: " . $e->getMessage());
        return false;
    };
}
?>