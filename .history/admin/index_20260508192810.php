<?php
require_once('inc/session.php');
require_once('inc/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - FreshNest</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #F6EEE8;
        }
        .sidebar {
            width: 250px;
            background: #E8DCCB;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .sidebar .logo {
            font-size: 24px;
            font-weight: bold;
            color: #5C4338;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            padding: 12px;
            color: #5C4338;
            text-decoration: none;
            margin: 5px 0;
            border-radius: 8px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #8B6A5B;
            color: white;
        }
        .main {
            margin-left: 250px;
            padding: 20px;
        }
        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .hero {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .hero h1 {
            color: #5C4338;
            margin-bottom: 10px;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card h3 {
            color: #8B6A5B;
            margin-bottom: 10px;
        }
        .card span {
            font-size: 32px;
            font-weight: bold;
            color: #5C4338;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">FreshNest Admin</div>
        <a href="index.php" class="active">Dashboard</a>
        <a href="cate.php">Categories</a>
        <a href="product.php">Products</a>
        <a href="ord.php">Orders</a>
        <a href="user.php">Users</a>
        <a href="masge.php">Messages</a>
    </div>
    
    <div class="main">
        <div class="topbar">
            <h2>Dashboard</h2>
            <a href="logout.php"><button class="btn-danger">Logout</button></a>
        </div>
        
        <div class="hero">
            <h1>Welcome Back, <?php echo htmlspecialchars($admin_name); ?>!</h1>
            <p>Track your business performance.</p>
        </div>
        
        <div class="cards">
            <?php
            // Get counts
            $users_result = mysqli_query($connect, "SELECT COUNT(*) as count FROM users");
            $users = mysqli_fetch_assoc($users_result);
            
            $orders_result = mysqli_query($connect, "SELECT COUNT(*) as count FROM orders");
            $orders = mysqli_fetch_assoc($orders_result);
            
            $products_result = mysqli_query($connect, "SELECT COUNT(*) as count FROM products");
            $products = mysqli_fetch_assoc($products_result);
            
            $messages_result = mysqli_query($connect, "SELECT COUNT(*) as count FROM contact_messages");
            $messages = mysqli_fetch_assoc($messages_result);
            ?>
            <div class="card">
                <h3>Users</h3>
                <span><?php echo $users['count']; ?></span>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <span><?php echo $orders['count']; ?></span>
            </div>
            <div class="card">
                <h3>Products</h3>
                <span><?php echo $products['count']; ?></span>
            </div>
            <div class="card">
                <h3>Messages</h3>
                <span><?php echo $messages['count']; ?></span>
            </div>
        </div>
    </div>
</body>
</html>