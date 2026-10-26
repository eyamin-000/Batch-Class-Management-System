<?php
// Load index.php
require_once 'config/db.php';
require_once 'models/BatchModel.php';

// Session already started in index.php
$database = new Database();
$db = $database->getConnection();
$batchModel = new BatchModel($db);

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Tutor';

// Data fetch
$summary = $batchModel->getSummary($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Manager Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --hot-red: #ee5253;
            --gray-black: #2d3436;
            --pure-black: #1e272e;
            --soft-white: #f5f6fa;
            --coral: #ff7f50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--soft-white);
            color: var(--gray-black);
            padding-bottom: 90px;
        }

        /* --- Header Section --- */
        .header {
            background: var(--pure-black);
            padding: 40px 25px 60px 25px;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            color: white;
            position: relative;
            animation: fadeInDown 0.8s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header p {
            font-size: 14px;
            opacity: 0.8;
            font-weight: 500;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 800;
            margin-top: 5px;
        }

        .header h1 span {
            color: var(--hot-red);
        }

        .logout-btn {
            position: absolute;
            top: 40px;
            right: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 8px 15px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* --- Stats Summary Cards --- */
        .stats-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 0 25px;
            margin-top: -30px;
        }

        .stat-card {
            background: white;
            padding: 25px 15px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            text-align: center;
            border: 1px solid rgba(238, 82, 83, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:active {
            transform: scale(0.95);
        }

        .stat-card h3 {
            font-size: 32px;
            color: var(--hot-red);
            font-weight: 800;
        }

        .stat-card p {
            font-size: 12px;
            font-weight: 700;
            color: #8395a7;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        /* --- Action List --- */
        .section-title {
            padding: 30px 25px 15px;
            font-weight: 800;
            font-size: 18px;
            color: var(--pure-black);
        }

        .action-list {
            padding: 0 25px;
        }

        .action-item {
            background: white;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .action-item:hover {
            transform: translateX(8px);
            box-shadow: 0 10px 20px rgba(238, 82, 83, 0.1);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            background: #fef1f1;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 15px;
            color: var(--hot-red);
        }

        .action-info h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-black);
        }

        .action-info p {
            font-size: 12px;
            color: #8395a7;
            margin-top: 2px;
        }

        /* --- Bottom Navigation --- */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 15px 10px 25px;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.05);
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            z-index: 100;
        }

        .nav-item {
            text-align: center;
            text-decoration: none;
            color: #b2bec3;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .nav-item.active {
            color: var(--hot-red);
        }

        .nav-dot {
            width: 5px;
            height: 5px;
            background: var(--hot-red);
            border-radius: 50%;
            margin: 0 auto;
            display: none;
        }

        .nav-item.active .nav-dot {
            display: block;
        }

    </style>
</head>
<body>

    <div class="header">
        <p>Good Morning,</p>
        <h1><?php echo htmlspecialchars($user_name); ?><span>.</span></h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <h3><?php echo $summary['students']; ?></h3>
            <a href="index.php?page=view_students" class="nav-item">

            <p>Students</p>
            </a>
        </div>
        <div class="stat-card">
            <h3><?php echo $summary['batches']; ?></h3>
            <p>Batches</p>
        </div>
    </div>

    <div class="section-title">Quick Management</div>

    <div class="action-list">
        <a href="index.php?page=batches" class="action-item">
            <div class="icon-box">📚</div>
            <div class="action-info">
                <h4>Manage Batches</h4>
                <p>Add new batch or set monthly fees</p>
            </div>
        </a>

        <a href="index.php?page=add_student" class="action-item">
            <div class="icon-box">👤</div>
            <div class="action-info">
                <h4>Add New Student</h4>
                <p>Enroll a student in your batch</p>
            </div>
        </a>

        <a href="index.php?page=payments" class="action-item">
            <div class="icon-box">💳</div>
            <div class="action-info">
                <h4>Fee Collection</h4>
                <p>Track monthly paid and pending dues</p>
            </div>
        </a>
    </div>

    <div class="bottom-nav">
        <a href="index.php" class="nav-item active">
            <span>Home</span>
            <div class="nav-dot"></div>
        </a>
        <a href="index.php?page=view_students" class="nav-item">
            <span>Students</span>
        </a>
        <a href="#" class="nav-item">
            <span>Reports</span>
        </a>
        <a href="#" class="nav-item">
            <span>Settings</span>
        </a>
    </div>

</body>
</html>