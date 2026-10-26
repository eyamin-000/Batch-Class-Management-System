<?php
// Load database in index.php
$user_id = $_SESSION['user_id'];

// --- FEE COLLECTION LOGIC ---
if (isset($_GET['action']) && $_GET['action'] == 'pay' && isset($_GET['id'])) {
    $student_id = $_GET['id'];
    if ($studentModel->updatePaymentStatus($student_id, 'Paid')) {
        echo "<script>alert('Payment Received! ✅'); window.location.href='index.php?page=view_students';</script>";
    }
}

// Student data fetching
$students = $studentModel->getAllStudents($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List - EduKhata</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --hot-red: #ee5253;
            --pure-black: #1e272e;
            --soft-bg: #f5f6fa;
            --paid-green: #10ac84;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { background-color: var(--soft-bg); padding-bottom: 40px; }

        /* --- Header --- */
        .header {
            background: var(--pure-black);
            padding: 30px 20px 50px;
            color: white;
            border-bottom-left-radius: 35px;
            border-bottom-right-radius: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn { color: white; text-decoration: none; font-weight: 700; font-size: 14px; }
        .header h1 { font-size: 22px; font-weight: 800; }

        .container { padding: 20px; max-width: 600px; margin: 0 auto; }

        /* --- Search Bar --- */
        .search-box {
            background: white;
            padding: 15px 20px;
            border-radius: 20px;
            margin-top: -30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            font-weight: 600;
        }

        /* --- Student Card --- */
        .student-card {
            background: white;
            padding: 20px;
            border-radius: 25px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid rgba(0,0,0,0.03);
            transition: 0.3s;
        }

        .student-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }

        .info h3 { font-size: 16px; font-weight: 800; color: #2d3436; margin-bottom: 4px; }
        .info p { font-size: 12px; color: #8395a7; font-weight: 600; margin-bottom: 2px; }
        .batch-tag { 
            display: inline-block;
            background: #f1f2f6; 
            color: #57606f; 
            padding: 3px 10px; 
            border-radius: 8px; 
            font-size: 10px; 
            font-weight: 800; 
            text-transform: uppercase;
        }

        /* Status Badge as Button */
        .status-badge {
            padding: 8px 15px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 800;
            text-align: center;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .status-unpaid { background: #ffe6e6; color: var(--hot-red); transition: 0.3s; }
        .status-unpaid:hover { background: var(--hot-red); color: white; }
        .status-paid { background: #e3f9f1; color: var(--paid-green); cursor: default; }

        .empty-state { text-align: center; padding: 50px 20px; color: #b2bec3; }
        
        .add-fab { 
            position: fixed; bottom: 30px; right: 30px; 
            background: var(--hot-red); color: white; 
            width: 60px; height: 60px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            text-decoration: none; font-size: 30px; box-shadow: 0 10px 25px rgba(238, 82, 83, 0.4); 
            z-index: 100;
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="index.php" class="back-btn">← Home</a>
        <h1>Students</h1>
        <div style="width: 40px;"></div>
    </div>

    <div class="container">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by name or mobile..." onkeyup="searchStudent()">
        </div>

        <div id="studentList">
            <?php if(empty($students)): ?>
                <div class="empty-state">
                    <p>No students found. Add your first student! 🎓</p>
                </div>
            <?php else: ?>
                <?php foreach($students as $student): ?>
                    <div class="student-card">
                        <div class="info">
                            <h3 class="student-name"><?= htmlspecialchars($student['student_name']) ?></h3>
                            <p class="student-mobile">📞 <?= htmlspecialchars($student['mobile']) ?></p>
                            <span class="batch-tag">📚 <?= htmlspecialchars($student['batch_name']) ?></span>
                        </div>
                        <div class="right-side" style="text-align: right;">
                            
                            <?php if($student['payment_status'] == 'Unpaid'): ?>
                                <a href="index.php?page=view_students&action=pay&id=<?= $student['id'] ?>" 
                                   class="status-badge status-unpaid"
                                   onclick="return confirm('Mark <?= htmlspecialchars($student['student_name']) ?> as Paid?')">
                                   Unpaid
                                </a>
                            <?php else: ?>
                                <span class="status-badge status-paid">Paid ✅</span>
                            <?php endif; ?>

                            <p style="font-size: 13px; font-weight: 800; margin-top: 8px; color: #2d3436;">
                                ৳<?= number_format($student['monthly_fee_custom']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <a href="index.php?page=add_student" class="add-fab">+</a>

    <script>
    function searchStudent() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let cards = document.getElementsByClassName('student-card');

        for (let i = 0; i < cards.length; i++) {
            let name = cards[i].querySelector('.student-name').innerText.toLowerCase();
            let mobile = cards[i].querySelector('.student-mobile').innerText.toLowerCase();
            
            if (name.includes(input) || mobile.includes(input)) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
    </script>

</body>
</html>