<?php
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    function getUserData($pdo, $userId) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>