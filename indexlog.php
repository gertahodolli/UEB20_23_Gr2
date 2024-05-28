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
        input[type="email"],
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
            <button type="submit" class="butoni" >Login</button>
            <button type="button" class="butoni cancel-button" onclick="window.location='index.php';">Cancel</button>
        </form>
        <p>If you don't have an account, <a href="signup.html">register here</a>.</p>
    </div>
    <!-- The Modal -->
    <div id="forgotModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('forgotModal').style.display='none'">&times;</span>
            <h2>Reset Password</h2>
            <form action="reset_password.php" method="post">
                <div class="form-group">
                    <label for="resetUsername">Username:</label>
                    <input type="text" id="resetUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password:</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="confirmNewPassword">Confirm New Password:</label>
                    <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>
                </div>
                <button type="submit" class="butoni" style="width: 92%;">Reset Password</button>
            </form>
        </div>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById('forgotModal');
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
