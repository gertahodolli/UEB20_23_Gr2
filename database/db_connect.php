<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "teatri";
$port = 3307;

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error); // Log the error
    die("Connection to the database failed. Please try again later."); // User-friendly message
}
?>
