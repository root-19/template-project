<?php
require_once "../Controller/Middleware.php";
Middleware::guest();

require_once "../Database/Database.php";
require_once "../Controller/UserModel.php";
require_once "../Controller/Auth.php";

// Initialize database connection, models, and auth class
$db = new Database();
$conn = $db->connect();
$userModel = new UserModel($conn);
$auth = new Auth($userModel);

$message = "";
// Handle registration request
$message = ''; // Default message variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the registerUser method to handle user registration
    $message = $auth->registerUser($name, $email, $password);

    if ($message === true) {
        $message = "your register done";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>


</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <!-- Notification -->
    <div id="notification" class="hidden fixed top-10 left-1/2 transform -translate-x-1/2 p-4 rounded-md text-white">
        <span id="notification-message"></span>
    </div>

    <!-- Modal -->
    <div class="bg-gray-700 bg-opacity-50 fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
            <?php if ($message): ?>
                <div class="bg-green-200 p-2 text-red-600 text-center rounded mb-4"><?php echo $message; ?></div>
            <?php endif; ?>
            <!-- Registration Form -->
            <form method="POST" class="space-y-4">
                <div>
                    <input type="text" name="name" placeholder="Name" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" name="register" class="w-full bg-blue-500 text-white py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Register</button>
            </form>

            <!-- Login Link -->
            <p class="mt-4 text-center text-gray-600">Already have an account? <a href="./login.php" class="text-blue-500 hover:underline">Login here</a></p>
        </div>
    </div>

    <script>
        // If the PHP message is set, show the notification
        <?php if ($message) : ?>
            showNotification('<?php echo $message; ?>', '<?php echo ($message == "Registration successful") ? "success" : "error"; ?>');
        <?php endif; ?>
    </script>

</body>
</html>
