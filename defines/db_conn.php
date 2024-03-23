<?php
// Credentails to connect to db.
// Database credentials
$servername = "localhost";
$username = "u956940883_aes";
$password = "9h]BS&bnzxE";
$database = "u956940883_aes";

// // Database credentials
// $servername = "localhost";
// $username = "root";
// $password = "root";
// $database = "aes_clinic_db";

try {
    // Creating a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    // Displaying error message if connection fails
    die("Connection failed: " . $e->getMessage());
}

return $pdo;