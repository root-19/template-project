<?php
require_once "../../Controller/Middleware.php";

// Start the session and check if the user is authenticated
Middleware::auth('user');

// Display welcome message
echo "Welcome to the User Dashboard, {$_SESSION['user_name']}!";
?>

<!-- Logout Button -->
<form method="POST" action="logout.php" class="mt-4">
    <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none">
        Logout
    </button>
</form>
