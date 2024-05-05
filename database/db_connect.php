<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "teatri"; // Ensure this database is already created
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
