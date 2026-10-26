<?php
class Database {
    // Database credentials
    private $host = "localhost";
    private $db_name = "student_manager";
    private $username = "root";
    private $password = "";
    public $conn;

    // Database connection function
    public function getConnection() {
        $this->conn = null;

        try {
            // PDO (PHP Data Objects)
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            $this->conn->exec("set names utf8");
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>