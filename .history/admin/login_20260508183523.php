<?php 
require_once "inc/conn.php";
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connect, trim($_POST['username']));
    $password = trim($_POST['password']);
    
    if (!empty($username) && !empty($password)) {
        // Use prepared statement
        $stmt = $connect->prepare("SELECT id, username, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $row = $result->fetch_assoc()) {
            // Verify password (support both plain text and hashed)
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                // If using plain text, hash it for future
                if ($password === $row['password']) {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $update = $connect->prepare("UPDATE admin SET password = ? WHERE id = ?");
                    $update->bind_param("si", $hashed, $row['id']);
                    $update->execute();
                }
                
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshNest - Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink: #EFD9D5;
            --bg: #F6EEE8;
            --sage: #BFC9B3;
            --beige: #E8DCCB;
            --nav: #8B6A5B;
            --dark: #5C4338;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--bg) 0%, var(--beige) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 30px;
            padding: 45px 35px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-card .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        .login-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .login-card .subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .field {
            text-align: left;
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .field input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid #e0e0e0;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: all 0.3s;
        }

        .field input:focus {
            outline: none;
            border-color: var(--nav);
            box-shadow: 0 0 0 3px rgba(139, 106, 91, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--nav);
            color: white;
            border: none;
            border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--dark);
            transform: translateY(-2px);
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--nav);
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <img src="../images/logo.png" alt="FreshNest" class="logo">
            <h1>Admin Login</h1>
            <p class="subtitle">Access the FreshNest Dashboard</p>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="field">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required autofocus>
                </div>
                
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" name="login" class="btn-login">Sign In</button>
            </form>
            
            <a href="../index.php" class="back-link">← Back to Website</a>
        </div>
    </div>
</body>
</html>