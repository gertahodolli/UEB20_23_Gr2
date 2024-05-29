<?php
session_start();
include 'database/db_connect.php'; // Include the connection script

$userId = $_SESSION['user_id']; // Assuming user ID is stored in session
$showDuration = isset($_GET['showDuration']) ? $_GET['showDuration'] : '00:00';

// Fetch user information
$stmt = $conn->prepare("SELECT mosha, student FROM user WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$mosha = $user['mosha'];
$student = $user['student'];

// Convert duration to minutes for comparison
$durationParts = explode(':', $showDuration);
$showDurationMinutes = ($durationParts[0] * 60) + $durationParts[1];

// Build query based on user information
$query = "SELECT id, tipi, cmimi FROM biletat WHERE 1=1";
if ($student) {
    if ($showDurationMinutes > 120) {
        $query .= " AND tipi IN ('Student for shows over 2 hours')";
    } else {
        $query .= " AND tipi IN ('Student Tickets')";
    }
} elseif ($mosha <= 10) {
    $query .= " AND tipi IN ('Kids and Seniors')";
} elseif ($mosha > 65) {
    $query .= " AND tipi IN ('Kids and Seniors')";
} else {
    if ($showDurationMinutes > 120) {
        $query .= " AND tipi IN ('Show over 2 hours')";
    } else {
        $query .= " AND tipi IN ('Regular Tickets')";
    }
}

$result = $conn->query($query);

$ticketTypes = array();
while ($row = $result->fetch_assoc()) {
    $ticketTypes[] = $row;
}

echo json_encode($ticketTypes);

$conn->close();
?>
