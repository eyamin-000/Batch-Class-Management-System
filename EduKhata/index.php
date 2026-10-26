<?php
session_start();

require_once 'config/db.php';
require_once 'models/BatchModel.php';
require_once 'models/StudentModel.php';

//Create Database Connection
$database = new Database();
$db = $database->getConnection();

// If User Logged in already
if (isset($_SESSION['user_id'])) {
    
    $user_id = $_SESSION['user_id'];
    $page = $_GET['page'] ?? 'home';

    // Models initializing
    if ($db) {
        $batchModel = new BatchModel($db);
        $studentModel = new StudentModel($db); // Student Model instantiating
        
        // Dashboard summary fetch
        $summary = $batchModel->getSummary($user_id);
    } else {
        die("Database connection failed. Please check config/db.php");
    }

    // --- ROUTING LOGIC ---
    switch ($page) {
        case 'batches':
            if (file_exists('views/batches.php')) {
                include 'views/batches.php';
            } else {
                echo "<h1>Batches file missing!</h1><a href='index.php'>Back</a>";
            }
            break;

        case 'add_student':
            if (file_exists('views/add_student.php')) {
                include 'views/add_student.php';
            } else {
                echo "<h1>Add Student file missing!</h1><a href='index.php'>Back</a>";
            }
            break;

        case 'view_students': // Notun Student list page routing
            if (file_exists('views/view_students.php')) {
                include 'views/view_students.php';
            } else {
                echo "<h1>Student List file missing!</h1><a href='index.php'>Back</a>";
            }
            break;

        case 'logout':
            session_destroy();
            header("Location: index.php");
            break;

        default:
            // Dashboard (Home)
            if (file_exists('views/dashboard.php')) {
                include 'views/dashboard.php';
            } else {
                echo "<h1>Dashboard file missing!</h1><a href='logout.php'>Logout</a>";
            }
            break;
    }
} 
//If  user not logged in
else {
    $page = $_GET['page'] ?? 'login';
    if ($page == 'signup') {
        include 'views/signup.php';
    } else {
        include 'views/login.php';
    }
}
?>