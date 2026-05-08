<?php
// 1. Start session management and include database configuration
session_start();
require_once __DIR__ . '/config.php';
// --- 2. Fetch Favorites Count for the header notification ---
$fav_count = 0;
if (isset($_SESSION['user_id'])) {
    $fav_user_id = $_SESSION['user_id'];
    $fav_count_query = "SELECT COUNT(*) AS total FROM favorites WHERE user_id = $fav_user_id";
    $fav_count_result = mysqli_query($conn, $fav_count_query);
    if ($fav_count_result) {
        $fav_count_row = mysqli_fetch_assoc($fav_count_result);
        $fav_count = $fav_count_row['total'];
    }
}

// --- 3. Check Authentication Status ---
// Verify if the user is logged in, otherwise set a flag to show login prompt
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : 0;

// --- 4. Database Integration: Fetch User Orders ---
// Performs a JOIN query to retrieve order details along with product info
$result = null;
if ($is_logged_in) {
    $query = "SELECT orders.order_id, orders.order_date, orders.total_price,
                     products.product_id, products.name, products.image, products.product_condition,
                     order_items.quantity, order_items.price
              FROM orders
              JOIN order_items ON orders.order_id = order_items.order_id
              JOIN products ON order_items.product_id = products.product_id
              WHERE orders.user_id = $user_id
              ORDER BY orders.order_id DESC";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FreshNest - My Orders</title>
<link rel="stylesheet" href="css/style.css" />

<style>
/* Styling for the orders page layout */
.orders-wrapper { padding: 60px 0; background-color: #f9f7f4; min-height: 80vh; }
.page-title-section { margin-bottom: 40px; }
.page-title-section h1 { font-size: 32px; color: #333; }

.order-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 15px rgba(0,0,0,0.03);
}

/* Auth Prompt CSS for non-registered users */
.auth-prompt {
    background: white;
    padding: 50px;
    border-radius: 25px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 500px;
    margin: 40px auto;
}
.auth-btn-group { display: flex; gap: 15px; justify-content: center; margin-top: 25px; }
.btn-login { background: #6b7a5f; color: white; padding: 12px 25px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; }
.btn-signup { border: 2px solid #6b7a5f; color: #6b7a5f; padding: 10px 25px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; }

.item-box { display: flex; align-items: center; gap: 25px; }
.item-box img { width: 120px; height: 120px; border-radius: 15px; object-fit: cover; }
.item-details h3 { font-size: 20px; color: #2b2b2b; margin-bottom: 4px; }
.order-id-text { color: #999; font-size: 13px; margin-bottom: 8px; display: block; }
.status-badge { display: inline-block; padding: 5px 15px; border-radius: 50px; font-size: 12px; font-weight: bold; }
.proc { background: #fff4e5; color: #d48806; }
.action-section { text-align: right; }
.item-price { font-size: 22px; font-weight: bold; color: #333; }
.order-details { margin-top: 10px; font-size: 14px; color: #555; line-height: 1.6; }
.btn-action { background-color: #b5c0a9; color: #333 !important; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 600; text-decoration: none; font-size: 13px; display: inline-block; margin-top: 10px; }

@media (max-width: 768px) {
    .order-card { flex-direction: column; text-align: center; gap: 15px; }
    .item-box { flex-direction: column; }
}
</style>
</head>

<body>

<header class="header">
    <div class="container row">
        <a class="brand" href="index.php">
            <img src="images/logo.png" alt="FreshNest Logo">
            <span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
        </a>
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="contact.php">Contact</a>
            <a href="orders.php">My Orders</a>
        </nav>
        <div class="header-right">
            <a class="header-fav" href="favorites.php">♥<?php if ($fav_count > 0) { ?><span class="fav-count"><?php echo $fav_count; ?></span><?php } ?></a>
            <a class="icon-btn" href="cart.php"><img alt="Cart" class="cart-icon" src="images/icon-cart.png"/></a>
            <?php if($is_logged_in && isset($_SESSION['user_name'])): ?>
                <a href="profile.php" class="user-avatar" style="text-decoration: none;">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </a>
            <?php else: ?>
                <a class="login-link" href="login.php" style="text-decoration: none;">login</a>
            <?php endif; ?>
    <a href="admin/login.php" style="background:#8B6A5B; color:white; padding:8px 16px; border-radius:25px; text-decoration:none; font-size:14px; font-weight:bold; margin-left:15px;">👑 Admin</a>
        </div>
    </div>
</header>

<main class="orders-wrapper">
    <div class="container">
        <div class="page-title-section">
            <h1>My Orders</h1>
        </div>

        <?php if (!$is_logged_in): ?>
            <div class="auth-prompt">
                <h2>Ready to track your orders?</h2>
                <p>Please log in or create an account to view your purchase history.</p>
                <div class="auth-btn-group">
                    <a href="login.php" class="btn-login">Login</a>
                    <a href="signup.php" class="btn-signup">Sign Up</a>
                </div>
            </div>

        <?php else: ?>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_row($result)) {
                    $order_id = $row[0]; $order_date = $row[1];
                    $product_id = $row[3]; $product_name = $row[4];
                    $image = $row[5]; $condition = $row[6];
                    $quantity = $row[7]; $price = $row[8];
                    $subtotal = $quantity * $price;
            ?>
            <div class="order-card">
                <div class="item-box">
                    <img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>">
                    <div class="item-details">
                        <h3><?php echo $product_name; ?></h3>
                        <span class="order-id-text">Order ID: #FN-<?php echo $order_id; ?></span>
                        <span class="order-id-text">Date: <?php echo $order_date; ?></span>
                        <span class="status-badge proc">Processing</span>
                        <div class="order-details">
                            <p><strong>Quantity Purchased:</strong> <?php echo $quantity; ?></p>
                            <p><strong>Condition:</strong> <?php echo $condition; ?></p>
                        </div>
                    </div>
                </div>
                <div class="action-section">
                    <span class="item-price">$<?php echo $subtotal; ?></span><br>
                    <a href="product-details.php?product_id=<?php echo $product_id; ?>" class="btn-action">Buy Again</a>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p style='text-align:center; color:#999;'>No orders found in your history.</p>";
            }
            ?>
        <?php endif; ?>
    </div>
</main>

<footer class="footer">
    <div class="container footer-grid">
        <div>
            <a class="brand" href="index.php">
                <img src="images/logo.png" alt="FreshNest Logo">
                <span class="name"><span class="fresh">Frsh</span><span class="nest">Nest</span></span>
            </a>
            <p class="muted">Giving furniture a second life since 2026. Sustainable, affordable, beautiful.</p>
        </div>
        <div>
            <h4>Quick links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <div>
            <h4>Category</h4>
            <ul>
                <li>Living Room</li><li>Bedroom</li><li>Kitchen</li><li>Office</li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li>support@freshnest.com</li><li>+1 (555) 123-4567</li><li>123 Green Street, Eco City</li>
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>© 2026 FreshNest. All rights reserved.</p>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select all action buttons for adding event listeners
    const buttons = document.querySelectorAll('.btn-action, .btn-login, .btn-signup');

    buttons.forEach(btn => {
        // UI Enhancement: Hover effect logic
        btn.addEventListener('mouseenter', () => {
            btn.style.opacity = "0.85";
            btn.style.transform = "translateY(-2px)";
            btn.style.transition = "0.3s cubic-bezier(0.4, 0, 0.2, 1)";
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.opacity = "1";
            btn.style.transform = "translateY(0)";
        });
        
        // UI Enhancement: Click feedback logic
        btn.addEventListener('mousedown', () => {
            btn.style.transform = "scale(0.95)";
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = "translateY(-2px) scale(1)";
        });
    });
});
</script>

</body>
</html>
<?php 
// 8. Close the MySQL database connection
mysqli_close($conn); 
?>