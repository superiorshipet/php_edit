<?php
// This file is included at the top of pages that need consistent header
if (!isset($fav_count)) {
    $fav_count = 0;
}

$is_logged_in = isset($_SESSION['user_id']);
?>
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
            <a class="header-fav" href="favorites.php">♥
                <?php if ($fav_count > 0): ?>
                    <span class="fav-count"><?php echo $fav_count; ?></span>
                <?php endif; ?>
            </a>
            <a class="icon-btn" href="cart.php">
                <img alt="Cart" class="cart-icon" src="images/icon-cart.png">
            </a>
            
            <?php if ($is_logged_in && isset($_SESSION['user_name'])): ?>
                <a href="profile.php" class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></a>
            <?php else: ?>
                <a class="login-link" href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>