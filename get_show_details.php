<?php
include 'database/db_connect.php'; // Include the connection script

if (isset($_POST['date'])) {
    $date = $_POST['date'];
    
    $stmt = $conn->prepare("
        SELECT s.emrin, s.regjisorin, s.duration, s.foto 
        FROM performances p 
        JOIN shfaqje s ON p.shfaqje_id = s.id 
        WHERE p.date = ?
    ");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $showDetails = $result->fetch_assoc();
    $stmt->close();

    echo json_encode($showDetails);
}

$conn->close();
?>
