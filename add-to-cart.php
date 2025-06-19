<?php
require_once 'config/db_conn.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Check if product exists and has enough stock
$stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
}

$product = $result->fetch_assoc();
if ($product['stock_quantity'] < $quantity) {
    echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
    exit;
}

// Check if product is already in cart
$stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if product already in cart
    $cart_item = $result->fetch_assoc();
    $new_quantity = $cart_item['quantity'] + $quantity;

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
} else {
    // Add new item to cart
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
}

if ($stmt->execute()) {
    // Get cart count for response
    $stmt = $conn->prepare("SELECT SUM(quantity) as cart_count FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart_count = $result->fetch_assoc()['cart_count'];

    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart successfully',
        'cart_count' => $cart_count
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding product to cart']);
}

$stmt->close();
$conn->close();
