<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - Student Manager Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* --- Root Colors & Reset --- */
        :root {
            --pastel-red: #ff6b6b;
            --coral: #ff7f50;
            --hot-red: #ee5253;
            --gray-black: #2d3436;
            --pure-black: #1e272e;
            --soft-white: #f9f9f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--soft-white);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            /* Subtle Background Animation */
            background: linear-gradient(-45deg, #f9f9f9, #ffe6e6, #f9f9f9);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* --- Auth Card Animation --- */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 50px 40px;
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            position: relative;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(255, 107, 107, 0.1);
        }

        .auth-header {
            margin-bottom: 35px;
            text-align: center;
        }

        .auth-header h2 {
            color: var(--gray-black);
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .auth-header h2 span {
            color: var(--hot-red);
        }

        .auth-header p {
            color: #8395a7;
            font-size: 15px;
            font-weight: 500;
        }

        /* --- Form Elements --- */
        .auth-form {
            text-align: left;
        }

        .input-group {
            margin-bottom: 24px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--gray-black);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #f1f2f6;
            border-radius: 16px;
            font-size: 15px;
            color: var(--pure-black);
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-group input:focus {
            border-color: var(--pastel-red);
            outline: none;
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.1);
            transform: scale(1.02);
        }

        /* --- Custom Button --- */
        .btn-primary {
            width: 100%;
            padding: 18px;
            background: var(--gray-black);
            color: #ffffff;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background: var(--hot-red);
            box-shadow: 0 15px 30px rgba(238, 82, 83, 0.3);
            transform: translateY(-3px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* --- Footer --- */
        .auth-footer {
            margin-top: 35px;
            font-size: 14px;
            color: #8395a7;
            text-align: center;
            font-weight: 500;
        }

        .auth-footer a {
            color: var(--hot-red);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .auth-footer a:hover {
            color: var(--gray-black);
        }

        /* Success/Error Toast */
        #message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            display: none;
            text-align: center;
        }

        .msg-success { background: #e3fcef; color: #00b894; }
        .msg-error { background: #ffe6e6; color: var(--hot-red); }

    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-header">
            <h2>Sign<span>Up</span></h2>
            <p>Join the future of student management.</p>
        </div>
        
        <form id="signupForm" class="auth-form">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="name" id="name" required placeholder="e.g. Alex Hunter">
            </div>

            <div class="input-group">
                <label>Mobile Number</label>
                <input type="tel" name="mobile" id="mobile" required placeholder="01XXXXXXXXX">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required placeholder="Create a secure password">
            </div>

            <button type="submit" class="btn-primary">Create Account</button>
        </form>

        <div class="auth-footer">
            <p>Already a member? <a href="index.php">Login Now</a></p>
        </div>
        
        <div id="message"></div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>