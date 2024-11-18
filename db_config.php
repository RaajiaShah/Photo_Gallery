<?php
// db_config.php - Database configuration and connection file

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gallery_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
    
}
?>