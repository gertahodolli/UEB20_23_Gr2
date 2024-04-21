<?php
require 'UserAuth.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userAuth = new UserAuth($username, '', $password);
    if ($userAuth->login()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p>Login failed. Please check your username and password.</p>";
    }
}
?>
