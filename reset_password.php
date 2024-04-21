<?php
require 'config.php'; // Include your database configuration

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmNewPassword'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); window.location='indexlog.html';</script>";
        exit();
    }

    if (!isValidPassword($newPassword)) {
        echo "<script>alert('Password must be at least 8 characters long and include at least one number and one special character.'); window.location='indexlog.php';</script>";
        exit();
    }

    // Assume you have a function to get the database connection
    $db = Database::getConnection();

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE users SET password = :password WHERE username = :username");
    $result = $stmt->execute(['password' => $hashedPassword, 'username' => $username]);

    if ($result) {
        echo "<script>alert('Your password has been updated successfully!'); window.location='indexlog.php';</script>";
    } else {
        echo "<script>alert('Failed to update password. Please try again.'); window.location='indexlog.php';</script>";
    }
}

function isValidPassword($password) {
    return preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[^A-Za-z0-9]).{8,}$/', $password);
}
?>
