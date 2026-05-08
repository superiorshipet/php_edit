<?php
include('inc/session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // First, update products in this category to NULL or delete them
    $stmt1 = $connect->prepare("UPDATE products SET category_id = NULL WHERE category_id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->close();
    
    // Then delete the category
    $stmt2 = $connect->prepare("DELETE FROM category WHERE category_id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();
}

header("Location: cate.php");
exit();
?>