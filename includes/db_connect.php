<?php
$servername = "localhost";
$username = "root";      // Default XAMPP username
$password = "";          // Default XAMPP password (empty)
$dbname = "sports_academy"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for special characters
$conn->set_charset("utf8mb4");
?>