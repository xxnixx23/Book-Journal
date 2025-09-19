<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['session_token'])) {
    // Delete session from the database
    require __DIR__ . '/../db_connect.php';
    $sql = "DELETE FROM sessions WHERE session_token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['session_token']]);

    // Clear the session data
    session_unset();
    session_destroy();
}

// Redirect to the login page
header("Location: ../index.php");
exit;
?>
