<?php
include('inc/session.php');

$name = $_POST['name'] ?? '';
$category_id = $_POST['category_id'] ?? '';
$product_condition = $_POST['product_condition'] ?? '';
$price = $_POST['price'] ?? '';
$stock = $_POST['stock'] ?? 0;
$description = $_POST['description'] ?? '';
$image = $_FILES['image']['name'] ?? '';
$image_tmp = $_FILES['image']['tmp_name'] ?? '';

if (!empty($image)) {
    move_uploaded_file($image_tmp, "../images/$image");
}

if (isset($_POST['addemp'])) {
    if (empty($name) || empty($price) || empty($category_id)) {
        echo '<script>alert("Please fill in all required fields");</script>';
    } else {
        // Use prepared statement
        $stmt = $connect->prepare("INSERT INTO products (name, price, product_condition, category_id, image, stock, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsisss", $name, $price, $product_condition, $category_id, $image, $stock, $description);
        
        if ($stmt->execute()) {
            header("Location: product.php");
            exit();
        } else {
            echo '<script>alert("Sorry, product was not saved: ' . $stmt->error . '");</script>';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/csss/style.css">
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo">Control Panel</div>
    <a href="index.php">Dashboard</a>
    <div class="profile-wrap">
        <a href="#" onclick="toggleMenuk()">Categories</a>
        <div class="dropdown" id="dropdownn">
            <a href="cate.php">View Categories</a>
        </div>
    </div>
    <a href="product.php" class="active">Products</a>
    <a href="ord.php">Orders</a>
    <div class="profile-wrap">
        <a href="#" onclick="toggleMenusss()">Users</a>
        <div class="dropdown" id="dropdown1">
            <a href="user.php">View Users</a>
        </div>
    </div>
    <a href="masge.php">Messages</a>
</div>

<div class="main">
    <header class="topbar">
        <button class="menu-btn" onclick="toggleSidebar()">☰</button>
        <div class="top-actions">
            <a href="logout.php"><button class="btn danger">Log Out</button></a>
        </div>
    </header>

    <div class="main-content">
        <header>
            <h1>Add New Product</h1>
        </header>

        <section class="card">
            <form action="" method="post" enctype="multipart/form-data">
                <label>Product Name *</label>
                <input type="text" name="name" placeholder="Enter product name" required>
                
                <label>Price *</label>
                <input type="number" step="0.01" name="price" placeholder="Enter price" required>
                
                <label>Stock Quantity *</label>
                <input type="number" name="stock" placeholder="Enter stock quantity" value="0" required>
                
                <label>Product Image</label>
                <input type="file" name="image" accept="image/*">
                
                <label>Condition</label>
                <select name="product_condition">
                    <option value="New">New</option>
                    <option value="Like New">Like New</option>
                    <option value="Refurbished">Refurbished</option>
                    <option value="Pre-loved">Pre-loved</option>
                </select>
                
                <label>Category *</label>
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <?php
                    $cat_query = "SELECT * FROM category ORDER BY category_name";
                    $cat_result = mysqli_query($connect, $cat_query);
                    while ($cat = mysqli_fetch_assoc($cat_result)) {
                        echo "<option value='{$cat['category_id']}'>{$cat['category_name']}</option>";
                    }
                    ?>
                </select>
                
                <label>Description</label>
                <textarea name="description" rows="4" placeholder="Enter product description"></textarea>
                
                <button type="submit" name="addemp" class="btn btn-primary">Save Product</button>
                <a href="product.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
            </form>
        </section>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>