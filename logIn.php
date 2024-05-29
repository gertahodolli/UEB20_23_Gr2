<?php
session_start();
include 'database.php'; // Ensure this is the correct path to your database connection

function customErrorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
    error_log("Error [$errno]: $errstr in $errfile on line $errline", 3, 'errors.log');
    echo "An error occurred. Please contact technical support.";
    return false;
}

set_error_handler("customErrorHandler");

function isAuthenticated() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
}

function checkSessionExpiry() {
    $timeout = 1800; // e.g., 30 minutes
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    $_SESSION['last_activity'] = time();
}

function isValidLogin($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password FROM susers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            return true;
        }
    }
    return false;
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo "An error occurred during login. Please contact technical support.";
}
return false; 
     

checkSessionExpiry();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = $_POST['username'];
$password = $_POST['password'];

if (isValidLogin($username, $password)) {
    $_SESSION['logged_in'] = true;
    $_SESSION['last_activity'] = time();
    header("Location: home.php"); // Redirect to home page
    exit();
} else {
    $login_error = "Invalid username or password.";
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Include your CSS and JS files -->
</head>
<body>
    <form method="POST" action="login.php">
        <label for="username">Username</label>
        <input type="text" name="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($login_error)) { echo "<p>$login_error</p>"; } ?>
</body>
</html>
