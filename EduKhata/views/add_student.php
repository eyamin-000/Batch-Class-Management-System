<?php
// Load Database model in index.php
$user_id = $_SESSION['user_id'];

// Batch fetching
$batch_query = "SELECT id, batch_name, monthly_fee FROM batches WHERE user_id = :u_id";
$b_stmt = $db->prepare($batch_query);
$b_stmt->bindParam(':u_id', $user_id);
$b_stmt->execute();
$batches = $b_stmt->fetchAll(PDO::FETCH_ASSOC);

// Form submit handle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_student'])) {
    $batch_id = $_POST['batch_id'];
    $student_name = $_POST['student_name'];
    $mobile = $_POST['mobile'];
    $monthly_fee_custom = $_POST['monthly_fee_custom'];
    
    if ($studentModel->createStudent($batch_id, $student_name, $mobile, $monthly_fee_custom)) {
        echo "<script>alert('Student Added Successfully! 🎉'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to add student!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - EduKhata</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #FF5F6D 0%, #FFC371 100%);
            --dark-bg: #1e272e;
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { 
            background: #f0f2f5;
            background-image: radial-gradient(circle at 20% 20%, rgba(255, 95, 109, 0.05) 0%, transparent 20%),
                              radial-gradient(circle at 80% 80%, rgba(255, 195, 113, 0.05) 0%, transparent 20%);
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* Unique Header */
        .header {
            background: var(--dark-bg);
            padding: 40px 20px 80px;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "";
            position: absolute;
            top: -50%; left: -20%;
            width: 200px; height: 200px;
            background: var(--primary-gradient);
            filter: blur(80px);
            opacity: 0.4;
        }

        .header h1 { color: white; font-size: 28px; font-weight: 800; position: relative; }
        .back-btn { 
            position: absolute; left: 20px; top: 40px; 
            color: white; text-decoration: none; font-weight: bold;
            background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 12px;
        }

        /* Form Card */
        .container { max-width: 450px; margin: -50px auto 0; padding: 0 20px; }
        
        .card {
            background: var(--glass-bg);
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
        }

        .input-group { margin-bottom: 22px; position: relative; }
        
        label { 
            display: block; font-size: 13px; font-weight: 700; color: #57606f; 
            margin-bottom: 10px; padding-left: 5px;
        }

        input, select {
            width: 100%;
            padding: 16px 20px;
            border-radius: 18px;
            border: 2px solid #edf0f5;
            background: #f8fafc;
            font-size: 15px;
            font-weight: 600;
            color: #2f3542;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #FF5F6D;
            background: white;
            box-shadow: 0 10px 20px rgba(255, 95, 109, 0.1);
            outline: none;
        }

        /* Custom Button */
        .btn-save {
            width: 100%;
            padding: 18px;
            margin-top: 10px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 18px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(255, 95, 109, 0.3);
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 95, 109, 0.4);
        }

        .btn-save:active { transform: translateY(0); }

        /* Floating icons style (Decoration) */
        .decoration-text {
            text-align: center; margin-top: 25px; color: #a4b0be; font-size: 13px; font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="index.php" class="back-btn">← Back</a>
        <h1>New Student</h1>
    </div>

    <div class="container">
        <div class="card">
            <form method="POST">
                <div class="input-group">
                    <label>Assign to Batch</label>
                    <select name="batch_id" required>
                        <option value="">-- Choose Batch --</option>
                        <?php foreach($batches as $batch): ?>
                            <option value="<?= $batch['id'] ?>"><?= htmlspecialchars($batch['batch_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label>Student Full Name</label>
                    <input type="text" name="student_name" placeholder="Ex: Eyamin Khan" required>
                </div>

                <div class="input-group">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" placeholder="018XXXXXXXX" required>
                </div>

                <div class="input-group">
                    <label>Monthly Fee (Custom)</label>
                    <input type="number" name="monthly_fee_custom" placeholder="Ex: 2500" required>
                </div>

                <button type="submit" name="save_student" class="btn-save">
                    Register Student
                </button>
            </form>
        </div>
        
        <p class="decoration-text">Keep track of your students effortlessly.</p>
    </div>

</body>
</html>