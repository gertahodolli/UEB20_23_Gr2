<?php
include 'database/db_connect.php'; // Include the connection script

$daysInMonth = date("t");  // Number of days in the current month
$firstDayOfMonth = date("w", strtotime(date("Y-m-01"))); // Day of week the month starts on

// Fetch performance dates from the database
$stmt = $conn->prepare("SELECT date FROM performances");
$stmt->execute();
$result = $stmt->get_result();
$datesWithShows = [];
while ($row = $result->fetch_assoc()) {
    $datesWithShows[] = $row['date'];
}
$stmt->close();

echo '<tr>';
for ($i = 0; $i < $firstDayOfMonth; $i++) {
    echo '<td class="notAvailable"></td>'; // Fill empty cells if month doesn't start on Sunday
}

$currentDay = 1;
while ($currentDay <= $daysInMonth) {
    if ($i % 7 == 0) {
        echo '</tr><tr>'; // Start a new row each week
    }
    $currentDate = date('Y-m') . '-' . str_pad($currentDay, 2, '0', STR_PAD_LEFT);
    $highlightClass = in_array($currentDate, $datesWithShows) ? 'highlight' : '';
    echo "<td class='$highlightClass' data-date='$currentDate'><span>$currentDay</span></td>";
    $currentDay++;
    $i++;
}

while ($i % 7 != 0) {
    echo '<td class="notAvailable"></td>'; // Fill empty cells after last day of the month
    $i++;
}

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

echo '</tr>';
?>
