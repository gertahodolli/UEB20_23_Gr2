<?php
session_start();
session_unset();
session_destroy();
setcookie("user_background", "", time() - 3600, "/"); // Delete the cookie
header("Location: indexlog.php");
exit();
?>
