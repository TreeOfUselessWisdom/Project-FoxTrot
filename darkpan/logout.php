<?php
// Start the session
session_start();

// Unset the session variables
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['email']);

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: signin.php");
exit;
?>