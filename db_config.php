<?php
// db_config.php - Database configuration and connection file

$servername = "0.0.0.0";
$username = "root";
$password = "root";
$dbname = "gallery_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
    
}
?>