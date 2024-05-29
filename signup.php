<?php
require 'UserAuth.php';
include 'database/db_connect.php'; // Ensure this is the correct path to your database connection
session_start();

function customErrorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
    error_log("Error [$errno]: $errstr in $errfile on line $errline", 3, 'errors.log');
    echo "An error occurred. Please contact technical support.";
    return false;
}

set_error_handler("customErrorHandler");

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
    
    try {
        if ($password !== $confirm_password) {
            throw new Exception("Passwords do not match.");
        } elseif (!isValidPassword($password)) {
            throw new Exception("Password must be at least 8 characters long and include at least one number and one special character.");
        } else {
            $userAuth = new UserAuth($firstname, $lastname, $username, $email, $password, $age, $student, $phone);
            if ($userAuth->signup()) {
                header("Location: indexlog.php");
                exit();
            } else {
                throw new Exception("Signup failed. Please try again.");
            }
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

if ($message) {
    echo "<script>alert('$message'); window.location='signup.html';</script>";
}
?>
