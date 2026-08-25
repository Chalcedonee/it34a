<?php

echo "<h2>TEST LOGGER FILE IS RUNNING</h2>";

require_once __DIR__ . '/config/config.php';

echo "<p>Config loaded.</p>";

if (isset($pdo)) {
    echo "<p style='color:green;'>PDO exists.</p>";
} else {
    die("<p style='color:red;'>PDO DOES NOT EXIST.</p>");
}

try {

    $result = $pdo->query("SELECT DATABASE() AS db");

    $row = $result->fetch();

    echo "<p>Connected database: <strong>" .
         htmlspecialchars($row['db']) .
         "</strong></p>";

} catch (PDOException $e) {

    die(
        "<h3>Database Test Failed</h3><pre>" .
        htmlspecialchars($e->getMessage()) .
        "</pre>"
    );
}

echo "<p style='color:green;'>Database connection works.</p>";

echo "<hr>";

echo "<h3>Testing activity_logs table...</h3>";

try {

    $result = $pdo->query("SHOW TABLES LIKE 'activity_logs'");

    if ($result->rowCount() === 0) {

        die(
            "<p style='color:red;'>activity_logs TABLE DOES NOT EXIST.</p>"
        );

    }

    echo "<p style='color:green;'>activity_logs table exists.</p>";

} catch (PDOException $e) {

    die(
        "<h3>Table Check Failed</h3><pre>" .
        htmlspecialchars($e->getMessage()) .
        "</pre>"
    );
}

echo "<hr>";

echo "<h3>Testing INSERT...</h3>";

try {

    $sql = "
        INSERT INTO activity_logs (
            user_id,
            user_email,
            activity_log_action,
            activity_log_status,
            activity_log_ip_address,
            activity_log_user_agent
        )
        VALUES (
            :user_id,
            :user_email,
            :action,
            :status,
            :ip,
            :user_agent
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':user_id'    => '1',
        ':user_email' => 'test@example.com',
        ':action'     => 'test_activity',
        ':status'     => 'success',
        ':ip'         => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Test'
    ]);

    echo "<h2 style='color:green;'>SUCCESS! Activity was logged.</h2>";

} catch (PDOException $e) {

    echo "<h2 style='color:red;'>INSERT FAILED</h2>";

    echo "<pre style='background:#eee;padding:15px;'>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
}
