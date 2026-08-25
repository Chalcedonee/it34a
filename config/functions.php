<?php
function redirect($path)
{
    // Ensure BASE_URL is defined; fallback to relative path if not loaded
    $baseUrl = defined('BASE_URL') ? BASE_URL : '';

    // Ensure there is a single leading slash on the path
    $formattedPath = '/' . ltrim($path, '/');

    // Prevent errors if output has already started
    if (!headers_sent()) {
        header("Location: " . $baseUrl . $formattedPath);
        exit();
    } else {
        echo "<script>window.location.href='" . $baseUrl . $formattedPath . "';</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=" . $baseUrl . $formattedPath . "'></noscript>";
        exit();
    }
}
?>