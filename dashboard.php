<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

echo "Welcome, " . htmlentities($_SESSION['username']) . "!";
echo "<br><a href='logout.php'>Logout</a>";
