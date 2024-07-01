<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "Projectdb3";

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Handle connection errors
    die('Connection failed: ' . $e->getMessage());
}
?>
