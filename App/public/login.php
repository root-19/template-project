<?php
require_once "../Controller/Middleware.php";



require_once "../Database/Database.php";
require_once "../Controller/UserModel.php";
require_once "../Controller/Auth.php";

$db = new Database();
$conn = $db->connect();
$userModel = new UserModel($conn);
$auth = new Auth($userModel);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Store the result of loginUser in $user
    $user = $auth->loginUser($email, $password);

    if ($user === false) {
        $error = "Invalid email or password."; // Handle invalid login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-gray-700 bg-opacity-50 fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            
            <!-- Show error message if login failed -->
            <?php if ($error): ?>
                <div class="bg-red-200 p-2 text-red-600 text-center rounded mb-4"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form method="POST" class="space-y-4">
                <div>
                    <input type="email" name="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" name="login" class="w-full bg-blue-500 text-white py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
            </form>

            <!-- Register Link -->
            <p class="mt-4 text-center text-gray-600">Don't have an account? <a href="./register.php" class="text-blue-500 hover:underline">Register here</a></p>
        </div>
    </div>
</body>
</html>
