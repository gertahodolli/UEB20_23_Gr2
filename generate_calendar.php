<?php
$daysInMonth = date("t");  // Number of days in the current month
$firstDayOfMonth = date("w", strtotime(date("Y-m-01"))); // Day of week the month starts on

echo '<tr>';
for ($i = 0; $i < $firstDayOfMonth; $i++) {
    echo '<td class="notAvailable"></td>'; // Fill empty cells if month doesn't start on Sunday
}

$currentDay = 1;
while ($currentDay <= $daysInMonth) {
    if ($i % 7 == 0) {
        echo '</tr><tr>'; // Start a new row each week
    }
    echo "<td><a href='#' class='date-link'>$currentDay</a></td>";
    $currentDay++;
    $i++;
}

while ($i % 7 != 0) {
    echo '<td class="notAvailable"></td>'; // Fill empty cells after last day of the month
    $i++;
}
echo '</tr>';
?>
