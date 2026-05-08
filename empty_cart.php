<?php
session_start();
require_once __DIR__ . '/config.php';
$fav_count = 0;

if (isset($_SESSION['user_id'])) {

    $fav_user_id = $_SESSION['user_id'];

    $fav_count_query = "SELECT COUNT(*) AS total 
                        FROM favorites 
                        WHERE user_id = $fav_user_id";

    $fav_count_result = mysqli_query($conn, $fav_count_query);

    if ($fav_count_result) {
        $fav_count_row = mysqli_fetch_assoc($fav_count_result);
        $fav_count = $fav_count_row['total'];
    }
}

if (!isset($_SESSION['user_id'])) {
    die("Please login first");
}

$user_id = $_SESSION['user_id'];

$cart_query = "SELECT * FROM cart WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_query);

if ($cart_result && mysqli_num_rows($cart_result) > 0) {

    $cart_row = mysqli_fetch_row($cart_result);
    $cart_id = $cart_row[0];

    $delete_query = "DELETE FROM cart_items WHERE cart_id = $cart_id";

    mysqli_query($conn, $delete_query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FreshNest - Cart Cleared</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="header">

<div class="container row">

<a class="brand" href="index.php">

<img src="images/logo.png"/>

<span class="name">
<span class="fresh">Frsh</span>
<span class="nest">Nest</span>
</span>

</a>

<div class="nav">

<a href="index.php">Home</a>
<a href="products.php">Products</a>
<a href="contact.php">Contact</a>
<a href="orders.php">My Orders</a>

</div>

<div class="header-right">

<a class="header-fav" href="favorites.php">

♥

<?php if ($fav_count > 0) { ?>

<span class="fav-count">
<?php echo $fav_count; ?>
</span>

<?php } ?>

</a>

<a class="icon-btn" href="cart.php">
<img src="images/icon-cart.png" class="cart-icon"/>
</a>

<?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>

<a href="profile.php" class="user-avatar" style="text-decoration:none;">

<?php echo strtoupper(substr($_SESSION['user_name'],0,1)); ?>

</a>

<?php else: ?>

<a class="login-link" href="login.php">
login
</a>

<?php endif; ?>

</div>
</div>
</div>

<div class="section">

<div class="container">

<div class="checkout-card" style="max-width:700px; margin:auto; text-align:center;">

<div class="card-body" style="padding:60px 30px;">

<h1 style="font-size:42px; margin-bottom:20px;">
🛒
</h1>

<h2 style="margin-bottom:15px;">
Your cart has been emptied
</h2>

<p class="muted" style="margin-bottom:30px;">
Continue shopping and discover more products
</p>

<a class="sum-btn" href="products.php">
Continue Shopping
</a>

</div>
</div>

</div>
</div>

<div class="footer">

<div class="container footer-grid">

<div>

<a class="brand" href="index.php">

<img src="images/logo.png"/>

<span class="name">

<span class="fresh">Frsh</span>
<span class="nest">Nest</span>

</span>

</a>

<p class="muted">

Giving furniture a second life since 2026.<br/>
Sustainable, affordable, beautiful.

</p>

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

<li><a href="products.php?category_id=1">Living Room</a></li>
<li><a href="products.php?category_id=2">Bedroom</a></li>
<li><a href="products.php?category_id=4">Kitchen</a></li>
<li><a href="products.php?category_id=3">Kids</a></li>

</ul>

</div>

<div>

<h4>Contact</h4>

<ul>

<li>
<a href="mailto:support@freshnest.com">
support@freshnest.com
</a>
</li>

<li>+1 (555) 123-4567</li>

<li>123 Green Street, Eco City</li>

</ul>

</div>

</div>

<div class="container footer-bottom">

© 2026 FreshNest. All rights reserved.

</div>

</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
