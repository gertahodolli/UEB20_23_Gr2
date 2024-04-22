<?php
require 'UserAuth.php';
session_start();

function isValidPassword($password) {
    return preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[^A-Za-z0-9]).{8,}$/', $password);
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (!isValidPassword($password)) {
        $message = "Password must be at least 8 characters long and include at least one number and one special character.";
    } else {
        $userAuth = new UserAuth($username, $email, $password);
        if ($userAuth->signup()) {
            // Regjistrimi i suksesshëm, ridrejto në faqen e hyrjes
            header("Location: indexlog.php");
            exit();
        } else {
            $message = "Signup failed. Please try again.";
        }
    }
}

// Nëse ka një mesazh, sinjalizoje atë dhe ridrejto në signup.html
if ($message) {
    echo "<script>alert('$message'); window.location='signup.html';</script>";
    exit(); // Sigurohuni të ndaloni ekzekutimin e PHP pas ridrejtimit
}
?>
