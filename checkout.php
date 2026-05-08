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


// Temporary user id
if (!isset($_SESSION['user_id'])) {

    $_SESSION['user_id'] = 1;
}


// Store user id
$user_id = $_SESSION['user_id'];


// Initialize variables
$total = 0;

$cart_id = 0;


// Get user cart
$cart_query = "SELECT * FROM cart 
               WHERE user_id = $user_id";

$cart_result = mysqli_query($conn, $cart_query);


// Check if cart exists
if ($cart_result && mysqli_num_rows($cart_result) > 0) {

    $cart_row = mysqli_fetch_row($cart_result);

    $cart_id = $cart_row[0];

}


// Get cart products
if ($cart_id > 0) {

    $items_query = "SELECT products.*, cart_items.quantity
                    FROM cart_items
                    JOIN products 
                    ON cart_items.product_id = products.product_id
                    WHERE cart_items.cart_id = $cart_id";

    $items_result = mysqli_query($conn, $items_query);

} else {

    $items_result = false;

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<!-- Page encoding -->
<meta charset="utf-8"/>

<!-- Responsive design -->
<meta name="viewport"
content="width=device-width, initial-scale=1.0"/>

<!-- Page title -->
<title>FreshNest - Checkout</title>

<!-- External CSS file -->
<link href="css/style.css" rel="stylesheet"/>

</head>

<body>


<!-- Header section -->

<div class="header">

<div class="container row">


<!-- Website logo -->

<a class="brand" href="index.php">

<img alt="FreshNest Logo"
src="images/logo.png"/>

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

</div>
</div>
</div>


<!-- Checkout section -->

<div class="section">

<div class="container checkout-page">


<!-- Checkout title -->

<h1 class="checkout-title">
Checkout
</h1>


<!-- Checkout note -->

<p class="checkout-note">
Complete your order details below.
</p>

<div class="checkout-grid2">


<!-- Order summary card -->

<div class="checkout-card">

<div class="card-head">

<h2>Order Summary</h2>

</div>

<div class="card-body">

<table class="checkout-table">


<!-- Table header -->

<tr>

<th>Product</th>
<th class="tc">Price</th>
<th class="tc">Qty</th>
<th class="tc">Subtotal</th>

</tr>

<?php

// Display products
if ($items_result && mysqli_num_rows($items_result) > 0) {

while ($row = mysqli_fetch_row($items_result)) {

$price = (float)$row[2];

$qty = (int)$row[8];

$subtotal = $price * $qty;


// Calculate total
$total += $subtotal;
?>

<tr>

<td>

<div class="checkout-product">


<!-- Product image -->

<div class="checkout-img-box">

<img class="checkout-img"
src="<?php echo $row[3]; ?>"/>

</div>


<!-- Product name -->
<span class="checkout-name">

<?php echo $row[1]; ?>

</span>

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

<td class="tc checkout-sub">
$<?php echo $subtotal; ?>
</td>

</tr>

<?php
}

} else {


// Empty cart message
echo "
<tr>
<td colspan='4'>

<div class='checkout-empty-msg'>
🛒 Your cart is empty.
</div>

</td>
</tr>";

}
?>

</table>

</div>


<!-- Total price section -->

<div class="card-foot">

<span class="total-label">
Total Price
</span>

<span class="total-price2">
$<?php echo $total; ?>
</span>

</div>

</div>


<!-- Shipping details card -->

<div class="checkout-card">

<div class="card-head">

<h2>Shipping Details</h2>

</div>

<div class="card-body form-body">


<!-- Checkout form -->

<form action="save_order.php"
method="post"
onsubmit="return validateCheckout()">


<!-- Hidden total price -->

<input type="hidden"
name="total_price"
value="<?php echo $total; ?>"/>


<!-- Delivery time -->

<div class="field2">

<label>
Delivery Time
</label>

<p class="delivery-time">
🚚 3-5 Business Days
</p>

</div>


<!-- Delivery address -->

<div class="field2">

<label for="address">
Delivery Address
</label>

<input id="address"
name="address"
placeholder="Enter your address"
required
type="text"/>

</div>


<!-- Payment methods -->

<div class="field2">

<label>
Payment Method
</label>


<!-- Cash payment -->

<label class="pay-option">

<input name="pay"
required
type="radio"
value="cash"/>

💵 Cash on Delivery

</label>


<!-- Card payment -->

<label class="pay-option">

<input name="pay"
type="radio"
value="card"/>

💳 Credit / Debit Card

</label>


<!-- Wallet payment -->

<label class="pay-option">

<input name="pay"
type="radio"
value="wallet"/>

📱 Digital Wallet

</label>

</div>


<!-- Free delivery message -->

<?php if ($total >= 150) { ?>

<p class="checkout-free-note">

✅ Your order includes free delivery!

</p>

<?php } ?>


<!-- Security message -->

<p class="checkout-security-note">

Your information is secure and protected.

</p>


<!-- Confirm order button -->

<input class="confirm-btn"
type="submit"
value="Confirm Order"/>

</form>

</div>
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

<img alt="FreshNest Logo"
src="images/logo.png"/>

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


<!-- Contact info -->

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


<!-- Form validation script -->

<script>

// Validate checkout form
function validateCheckout(){

let address = document.getElementById("address").value;


// Check if address is empty
if(address.trim() == ""){

alert("Please enter your address");

return false;

}

return true;

}

</script>

</body>
</html>

<?php

// Close database connection
mysqli_close($conn);

?>