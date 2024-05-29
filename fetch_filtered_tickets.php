<?php
session_start();
include 'database/db_connect.php'; // Include the connection script

$userId = $_SESSION['user_id']; // Assuming user ID is stored in session

// Fetch user information
$stmt = $conn->prepare("SELECT mosha, student FROM user WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$mosha = $user['mosha'];
$student = $user['student'];

// Build query based on user information
$query = "SELECT id, tipi FROM biletat WHERE 1=1";
if ($student) {
    $query .= " AND tipi IN ('Student Tickets', 'Student for shows over 2 hours')";
} elseif ($mosha < 15) {
    $query .= " AND tipi IN ('Kids and Seniors')";
} elseif ($mosha > 65) {
    $query .= " AND tipi IN ('Kids and Seniors')";
} else {
    $query .= " AND tipi NOT IN ('Kids and Seniors')";
}

$result = $conn->query($query);

$ticketTypes = array();
while ($row = $result->fetch_assoc()) {
    $ticketTypes[] = $row;
}

echo json_encode($ticketTypes);

$conn->close();
?>
