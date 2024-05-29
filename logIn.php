<?php
session_start(); // Start the session at the very beginning
include 'database/db_connect.php';

function isAuthenticated() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
}

function checkSessionExpiry() {
    $timeout = 180; // e.g., 30 minutes
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
    $stmt = $conn->prepare("SELECT id, passHash FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $passHash);
        $stmt->fetch();
        if (password_verify($password, $passHash)) {
            return $userID;
        }
    }
    return false;
}

include 'database/db_connect.php'; // Ensure this path is correct

// Check if login form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userID = isValidLogin($username, $password);
    if ($userID !== false) {
        $_SESSION['user_id'] = $userID; // Storing user ID
        $_SESSION['logged_in'] = true; // Flag to check if the user is logged in
        $_SESSION['last_activity'] = time(); // To handle session timeout
        header("Location: index.php"); // Redirect to the home page after login
        exit();
    } else {
        // Optional: Handle login failure (e.g., display error message)
        $login_error = "Invalid username or password.";
    }
}

// Then, verify user authentication (only after handling the login form)
if (isAuthenticated()) {
    checkSessionExpiry();
    header("Location: index.php"); // Redirect to home page if already authenticated
    exit();
}

// Continue showing the login page or other content if not submitting the login form or if login fails
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        html, body {
            height: 100vh;
            overflow-y: hidden;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: rgba(145, 15, 18, 0.7);
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            opacity: 0.8;
        }
        .cancel-button {
            background-color:rgba(145, 15, 18, 0.7);  /* Grey background for cancel */
            color: white;
        }
        a {
            color: rgba(145, 15, 18, 0.7);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php if (isset($login_error)): ?>
        <p class="error"><?php echo $login_error; ?></p>
    <?php endif; ?>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="butoni">Login</button>
            <button type="button" class="butoni cancel-button" onclick="window.location='index.php';">Cancel</button>
        </form>
        <p>If you don't have an account, <a href="signup.html">register here</a>.</p>
    </div>
</body>
</html>
