<?php
session_start();

// Check if login form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'database.php'; // Assuming you have a separate database connection setup
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isValidLogin($username, $password)) { // Assume this function validates credentials
        $_SESSION['user_id'] = getUserID($username); // Storing user ID
        $_SESSION['logged_in'] = true; // Flag to check if the user is logged in
        $_SESSION['last_activity'] = time(); // To handle session timeout
        header("Location: dashboard.php"); // Redirect to a logged-in only area if needed
        exit();
    } else {
        // Optional: Handle login failure (e.g., display error message)
        $login_error = "Invalid username or password.";
    }
}

// Continue showing the login page or other content if not submitting the login form or if login fails
?>