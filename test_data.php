<?php
require_once 'config/db_conn.php';

// Check categories
echo "<h2>Categories:</h2>";
$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error checking categories: " . mysqli_error($conn);
} else {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row['category_id'] . " - Name: " . $row['name'] . "<br>";
        }
    } else {
        echo "No categories found.<br>";
    }
}

// Check products
echo "<h2>Products:</h2>";
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error checking products: " . mysqli_error($conn);
} else {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row['product_id'] . " - Name: " . $row['name'] . " - Price: " . $row['price'] . "<br>";
        }
    } else {
        echo "No products found.<br>";
    }
}
