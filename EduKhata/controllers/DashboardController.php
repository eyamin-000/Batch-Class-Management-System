<?php
require_once 'config/db.php';
require_once 'models/BatchModel.php';

$database = new Database();
$db = $database->getConnection();
$batchModel = new BatchModel($db);

// User logged in Check (Security)
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$summary = $batchModel->getSummary($user_id);
?>