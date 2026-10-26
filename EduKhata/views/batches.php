<?php
require_once 'config/db.php';
require_once 'models/BatchModel.php';

$database = new Database();
$db = $database->getConnection();
$batchModel = new BatchModel($db);

$user_id = $_SESSION['user_id'];

// Form submit handle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_batch'])) {
    $name = $_POST['batch_name'];
    $fee = $_POST['monthly_fee'];
    if($batchModel->createBatch($user_id, $name, $fee)) {
        echo "<script>alert('Batch Created Successfully!'); window.location.href='index.php?page=batches';</script>";
    }
}

// Batches fetch
$query = "SELECT * FROM batches WHERE user_id = :u_id ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(':u_id', $user_id);
$stmt->execute();
$batches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Batches - EduKhata</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --hot-red: #ee5253;
            --pure-black: #1e272e;
            --soft-bg: #f5f6fa;
            --glass: rgba(255, 255, 255, 0.9);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { background-color: var(--soft-bg); color: var(--pure-black); padding-bottom: 30px; }

        /* --- Header --- */
        .top-bar {
            background: var(--pure-black);
            padding: 25px;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .back-link { color: white; text-decoration: none; font-size: 20px; font-weight: bold; }

        /* --- Form Card --- */
        .container { padding: 20px; max-width: 600px; margin: 0 auto; }

        .add-card {
            background: white;
            padding: 25px;
            border-radius: 25px;
            margin-top: -40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border: 1px solid rgba(238, 82, 83, 0.1);
        }

        .add-card h2 { font-size: 18px; margin-bottom: 20px; font-weight: 800; }

        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 8px; color: #8395a7; text-transform: uppercase; }
        
        input {
            width: 100%;
            padding: 14px 18px;
            border-radius: 15px;
            border: 2px solid #f1f2f6;
            font-size: 14px;
            transition: 0.3s;
        }

        input:focus { border-color: var(--hot-red); outline: none; background: #fffafa; }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--pure-black);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover { background: var(--hot-red); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(238, 82, 83, 0.2); }

        /* --- Batch List --- */
        .list-title { margin: 30px 0 15px; font-weight: 800; font-size: 18px; display: flex; justify-content: space-between; align-items: center; }
        .count-badge { background: #ffe6e6; color: var(--hot-red); font-size: 12px; padding: 4px 12px; border-radius: 20px; }

        .batch-card {
            background: white;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 6px solid var(--pure-black);
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }

        .batch-card:hover { border-left-color: var(--hot-red); transform: scale(1.02); }

        .batch-info h3 { font-size: 16px; font-weight: 700; color: #2d3436; }
        .batch-info p { font-size: 13px; color: #8395a7; margin-top: 4px; font-weight: 600; }
        
        .fee-tag {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 12px;
            font-weight: 800;
            color: var(--hot-red);
            font-size: 14px;
        }

        .empty-state { text-align: center; padding: 40px; color: #b2bec3; }
    </style>
</head>
<body>

    <div class="top-bar">
        <a href="index.php" class="back-link">←</a>
        <h1 style="font-size: 20px; font-weight: 800;">Manage Batches</h1>
    </div>

    <div class="container">
        <div class="add-card">
            <h2>Create New Batch</h2>
            <form method="POST">
                <div class="input-group">
                    <label>Batch Name</label>
                    <input type="text" name="batch_name" placeholder="e.g. Class 10 Math (Night)" required>
                </div>
                <div class="input-group">
                    <label>Monthly Fee (BDT)</label>
                    <input type="number" name="monthly_fee" placeholder="e.g. 2000" required>
                </div>
                <button type="submit" name="add_batch" class="btn-submit">Create Batch Now</button>
            </form>
        </div>

        <div class="list-title">
            Your Active Batches
            <span class="count-badge"><?php echo count($batches); ?> Total</span>
        </div>

        <?php if(empty($batches)): ?>
            <div class="empty-state">
                <p>No batches found. Create your first batch above!</p>
            </div>
        <?php else: ?>
            <?php foreach($batches as $batch): ?>
                <div class="batch-card">
                    <div class="batch-info">
                        <h3><?php echo htmlspecialchars($batch['batch_name']); ?></h3>
                        <p>ID: #<?php echo $batch['id']; ?> • Created: <?php echo date('d M', strtotime($batch['created_at'])); ?></p>
                    </div>
                    <div class="fee-tag">
                        ৳<?php echo number_format($batch['monthly_fee']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>