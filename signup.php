<?php
require 'UserAuth.php';
include 'database/db_connect.php';
session_start();

function isValidPassword($password) {
    return preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[^A-Za-z0-9]).{8,}$/', $password);
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = $_POST['age'];
    $student = isset($_POST['student']) ? 1 : 0;
    $phone = $_POST['phone'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (!isValidPassword($password)) {
        $message = "Password must be at least 8 characters long and include at least one number and one special character.";
    } else {
        // If the password is valid, proceed to create a new user instance
        $userAuth = new UserAuth($firstname, $lastname, $email, $username, $password, $age, $student, $phone);

        // Check if user registration is successful
        if ($userAuth->signup()) {
            // Registration successful, redirect to the login page
            header("Location: indexlog.php");
            exit();
        } else {
            // Handle failure, possibly due to existing username or email
            $message = "Signup failed. Please try again.";
        }
    }
}

// If there is a message, alert it and redirect to signup.html
if ($message) {
    echo "<script>alert('$message'); window.location='signup.html';</script>";
    exit(); // Ensure to stop PHP execution after the redirect
}
?>
