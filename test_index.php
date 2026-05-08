<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<h1>FreshNest Test</h1>";
$conn = mysqli_connect("localhost", "root", "", "project_data1");
if ($conn) {
    echo "<p style='color:green'>✅ Database connected successfully!</p>";
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
    if ($result) {
        $row = mysqli_fetch_row($result);
        echo "<p>📦 Total products: " . $row[0] . "</p>";
    }
} else {
    echo "<p style='color:red'>❌ Database error: " . mysqli_connect_error() . "</p>";
}
?>
