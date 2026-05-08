<?php
include('inc/session.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/csss/style.css">
    <style>
        .stock-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .stock-high { background: #d4edda; color: #155724; }
        .stock-low { background: #fff3cd; color: #856404; }
        .stock-out { background: #f8d7da; color: #721c24; }
    </style>
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
            <h1>Products Management</h1>
            <a href="ins_pro.php" title="Add Product"><img src="img/ins.png" style="width: 40px;"></a>
        </header>

        <section class="card">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Condition</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sel_query = "SELECT * FROM products ORDER BY product_id DESC";
                    $result = mysqli_query($connect, $sel_query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $stock_class = '';
                        if ($row['stock'] <= 0) $stock_class = 'stock-out';
                        elseif ($row['stock'] <= 5) $stock_class = 'stock-low';
                        else $stock_class = 'stock-high';
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><img src="../<?php echo $row['image']; ?>" width="50" height="50" style="object-fit:cover; border-radius:8px;"></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><span class="stock-badge <?php echo $stock_class; ?>"><?php echo $row['stock']; ?></span></td>
                            <td><?php echo htmlspecialchars($row['product_condition']); ?></td>
                            <td>
                                <a href="se_pro.php?id=<?php echo $row['product_id']; ?>"><img src="img/se.png" width="28" title="View"></a>
                                <a href="de_pro.php?id=<?php echo $row['product_id']; ?>" onclick="return confirm('Delete this product?')"><img src="img/de.png" width="28" title="Delete"></a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (mysqli_num_rows($result) == 0): ?>
                        <tr><td colspan="7" style="text-align:center;">No products found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>