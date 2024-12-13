<?php
require_once "../../Controller/Middleware.php";
Middleware::auth('admin');

echo "Welcome to the User Dashboard, {$_SESSION['user_name']}!";
?>