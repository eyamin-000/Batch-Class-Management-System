<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Signup Function
    public function register($name, $mobile, $password) {
        try {
            // Securing Password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $query = "INSERT INTO users (name, mobile, password) VALUES (:name, :mobile, :password)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->bindParam(':password', $hashed_password);

            return $stmt->execute();
        } catch (PDOException $e) {
            
            return false;
        }
    }

    // Login Function
    public function login($mobile, $password) {
        try {
            $query = "SELECT * FROM users WHERE mobile = :mobile LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':mobile', $mobile);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>