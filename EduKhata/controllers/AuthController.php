<?php
session_start();
if (!file_exists('../config/db.php')) {
    die(json_encode(["status" => "error", "message" => "db.php file not found at ../config/db.php"]));
}
require_once '../config/db.php';
require_once '../models/UserModel.php';

$database = new Database();
$database->getConnection();
$db = $database->conn;
$userModel = new UserModel($db);

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mobile = $_POST['mobile'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action == 'signup') {
        $name = $_POST['name'] ?? '';
        if ($userModel->register($name, $mobile, $password)) {
            echo json_encode(["status" => "success", "message" => "Account created! Redirecting to Login..."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Mobile already exists or Database error."]);
        }
    } 
    elseif ($action == 'login') {
        $user = $userModel->login($mobile, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo json_encode(["status" => "success", "message" => "Login successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid Mobile or Password."]);
        }
    }
}
?>