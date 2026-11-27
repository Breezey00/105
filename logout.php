<?php
session_start();

// Restarts the session by erasing the user data needed for the account , ends it and redirects the user to the login page
$_SESSION = [];
session_destroy();
header("Location: login.php");
exit;
?>