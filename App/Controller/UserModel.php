<?php

class UserModel {
    private $conn;
    private $accounts = "users";

    public function __construct($db) {
        $this->conn = $db;
    }
  
    public function register($name, $email, $password, $role) {
        // Check if the email already exists
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // If email exists, return false (indicating a failure)
            return false;
        }

        // If email doesn't exist, insert the new user into the database
        $query = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // Hash the password before saving it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters to the query
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        // Execute the query
        if ($stmt->execute()) {
            return true;  // Registration successful
        }

        return false;  // Registration failed
    }

    public function login($email, $password) {
        // Prepare SQL query to get the user by email
        $stmt = $this->conn->prepare("SELECT id, name, email, role, password FROM users WHERE email = ?");
        
        // Bind the parameter using PDO's bindParam method
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if a user is found
        if ($user) {
            // Verify the password against the stored hash
            if (password_verify($password, $user['password'])) {
                return $user;  // Return user data if password is correct
            }
        }
        return false;  // Return false if no user found or password mismatch
    }
}
?>
