<?php
// Credentails to connect to db.
// Database credentials
$servername = "localhost";
$username = "root";
$password = "root";
$database = "aes_clininc_db";

try {
    // Creating a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    // Displaying error message if connection fails
    die("Connection failed: " . $e->getMessage());
}

return $conn;