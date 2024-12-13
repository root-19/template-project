<?php
session_start(); // Start the session

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the registration page
header("Location: ../../public/register.php");
exit();
