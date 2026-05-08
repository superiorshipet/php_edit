<?php

// Start session
session_start();


// Connect to database
require_once __DIR__ . '/config.php';

// Favorites count
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


/* Login validation */
if (!isset($_SESSION['user_id'])) {

echo "
<script>
alert('Please login first');
window.location='login.php';
</script>
";

exit();

}


// Store user id
$user_id = $_SESSION['user_id'];


// Initialize variables
$total = 0;

$cart_id = 0;


// Get user cart
$cart_query = "SELECT * FROM cart WHERE user_id = $user_id";

$cart_result = mysqli_query($conn, $cart_query);


// Check if cart exists
if ($cart_result && mysqli_num_rows($cart_result) > 0) {

    $cart_row = mysqli_fetch_row($cart_result);

    $cart_id = $cart_row[0];
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<!-- Page encoding -->
<meta charset="utf-8"/>

<!-- Responsive design -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- Page title -->
<title>FreshNest - Cart</title>

<!-- External CSS -->
<link href="css/style.css" rel="stylesheet"/>

</head>

<body>


<!-- Header section -->

<div class="header">

<div class="container row">


<!-- Website logo -->

<a class="brand" href="index.php">

<img src="images/logo.png"/>

<span class="name">

<span class="fresh">Frsh</span>
<span class="nest">Nest</span>

</span>

</a>


<!-- Navigation menu -->

<div class="nav">

<a href="index.php">Home</a>
<a href="products.php">Products</a>
<a href="contact.php">Contact</a>
<a href="orders.php">My Orders</a>

</div>


<!-- Header right section -->

<div class="header-right">


<!-- Favorites icon -->

<a class="header-fav" href="favorites.php">

♥

<?php if ($fav_count > 0) { ?>

<span class="fav-count">
<?php echo $fav_count; ?>
</span>

<?php } ?>

</a>


<!-- Cart icon -->

<a class="icon-btn" href="cart.php">

<img src="images/icon-cart.png"
class="cart-icon"/>

</a>


<!-- User avatar or login -->

<?php if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>

<a href="profile.php"
class="user-avatar"
style="text-decoration: none;">

<?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>

</a>

<?php else: ?>

<a class="login-link"
href="login.php"
style="text-decoration: none;">

login

</a>

<?php endif; ?>

    <a href="admin/login.php" style="background:#8B6A5B; color:white; padding:8px 16px; border-radius:25px; text-decoration:none; font-size:14px; font-weight:bold; margin-left:15px;">👑 Admin</a>
</div>
</div>
</div>


<!-- Cart section -->

<div class="section">

<div class="container cart-page">


<!-- Cart title -->

<h1 class="cart-title">
Shopping Cart
</h1>

<div class="cart-grid">


<!-- Cart table -->

<div class="cart-card">

<div class="cart-table-wrap">

<table class="cart-table">

<tr>

<th>Product Image</th>
<th>Product Name</th>
<th class="tc">Price</th>
<th class="tc">Quantity</th>
<th class="tc">Subtotal</th>
<th class="tc delete-col">Delete</th>

</tr>

<?php

// Check if cart has products
if ($cart_id > 0) {

$query = "SELECT products.*, cart_items.quantity
          FROM cart_items
          JOIN products 
          ON cart_items.product_id = products.product_id
          WHERE cart_items.cart_id = $cart_id";

$result = mysqli_query($conn, $query);


// Display cart products
if ($result && mysqli_num_rows($result) > 0) {

while ($row = mysqli_fetch_row($result)) {

$price = (float)$row[2];

$qty = (int)$row[8];

$subtotal = $price * $qty;


// Calculate total price
$total += $subtotal;
?>

<tr>

<td>

<!-- Product image -->

<div class="cart-img-box">

<img class="cart-img"
src="<?php echo $row[3]; ?>"/>

</div>

</td>

<td>

<!-- Product name -->

<div class="cart-name">
<?php echo $row[1]; ?>
</div>


<!-- Product condition -->

<div class="cart-cond">
<?php echo $row[4]; ?>
</div>

</td>


<!-- Product price -->

<td class="tc">

$<?php echo $price; ?>

</td>


<!-- Product quantity -->
<td class="tc">

<?php echo $qty; ?>

</td>


<!-- Product subtotal -->

<td class="tc cart-sub">

$<?php echo $subtotal; ?>

</td>


<!-- Remove product -->

<td class="tc delete-col">

<a href="remove.php?product_id=<?php echo $row[0]; ?>"
onclick="return confirm('Are you sure you want to remove this item?')">

🗑

</a>

</td>

</tr>

<?php
}

} else {


// Empty cart message
echo "
<tr>
<td colspan='6'>

<div class='cart-empty-msg'>
🛒 Your cart is empty
</div>

<a class='cart-continue-btn' href='products.php'>
Continue Shopping
</a>

</td>
</tr>";
}

} else {


// No cart found
echo "
<tr>
<td colspan='6'>

<div class='cart-empty-msg'>
🛒 Your cart is empty
</div>

<a class='cart-continue-btn' href='products.php'>
Continue Shopping
</a>

</td>
</tr>";
}
?>

</table>

</div>


<!-- Empty cart button -->

<a class="empty-btn" href="empty_cart.php">
Empty Cart
</a>

</div>


<!-- Order summary -->

<div class="summary-card">


<!-- Subtotal -->

<div class="sum-row">

<span class="muted">
Subtotal
</span>

<span class="sum-strong">
$<?php echo $total; ?>
</span>

</div>


<!-- Delivery -->

<div class="sum-row">

<span class="muted">
Delivery
</span>

<span class="sum-free">
Free
</span>

</div>

<div class="sum-divider"></div>


<!-- Total price -->

<div class="sum-total">

<span>
Total Price
</span>

<span>
$<?php echo $total; ?>
</span>

</div>


<!-- Free delivery message -->

<?php if ($total >= 150) { ?>

<p class="cart-delivery-note">

✅ You got free delivery on your order!

</p>

<?php } else { ?>

<p class="cart-delivery-note">

🚚 Free delivery on orders over $150

</p>

<?php } ?>


<!-- Checkout button -->

<a class="sum-btn" href="checkout.php">
Proceed to Checkout
</a>

</div>

</div>
</div>
</div>


<!-- Footer section -->

<div class="footer">

<div class="container footer-grid">


<!-- Footer logo -->

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


<!-- Quick links -->

<div>

<h4>Quick links</h4>

<ul>

<li><a href="index.php">Home</a></li>
<li><a href="products.php">Products</a></li>
<li><a href="contact.php">Contact</a></li>

</ul>

</div>


<!-- Categories -->

<div>

<h4>Category</h4>

<ul>

<li><a href="products.php?category_id=1">Living Room</a></li>
<li><a href="products.php?category_id=2">Bedroom</a></li>
<li><a href="products.php?category_id=4">Kitchen</a></li>
<li><a href="products.php?category_id=3">Kids</a></li>

</ul>

</div>


<!-- Contact information -->

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


<!-- Footer bottom -->

<div class="container footer-bottom">

© 2026 FreshNest. All rights reserved.

</div>

</div>

</body>
</html>

<?php

// Close database connection
mysqli_close($conn);

?>
