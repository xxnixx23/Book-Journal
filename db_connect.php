<?php
$servername = "localhost";  // Keep the variable name as $servername
$username = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "journal";  // Your database name

// Create a PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);  // Use $servername here
    // Set PDO to throw exceptions for errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If there's an error connecting, display an error message
    die("Connection failed: " . $e->getMessage());
}
?>
