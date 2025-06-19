<?php
require_once 'config/db_conn.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to place an order']);
    exit;
}

// Validate required fields
$required_fields = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'address',
    'city',
    'state',
    'zip'
];

$missing_fields = [];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields',
        'missing_fields' => $missing_fields
    ]);
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    $user_id = $_SESSION['user_id'];

    // Get cart items and calculate total
    $stmt = $conn->prepare("
        SELECT c.quantity, p.product_id, p.price, p.stock_quantity
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Your cart is empty');
    }

    $cart_items = [];
    $subtotal = 0;

    while ($item = $result->fetch_assoc()) {
        // Check stock availability
        if ($item['stock_quantity'] < $item['quantity']) {
            throw new Exception('Some items in your cart are out of stock');
        }

        $cart_items[] = $item;
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Calculate totals
    $shipping = 5.00;
    $tax = round($subtotal * 0.10, 2);
    $total = round($subtotal + $shipping + $tax, 2);

    // Create shipping address
    $shipping_address = implode(", ", [
        trim($_POST['address']),
        trim($_POST['city']),
        trim($_POST['state']),
        trim($_POST['zip'])
    ]);

    // Create order
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, total_amount, shipping_address, status)
        VALUES (?, ?, ?, 'pending')
    ");
    $stmt->bind_param("ids", $user_id, $total, $shipping_address);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Add order items and update stock
    $stmt = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price_per_unit)
        VALUES (?, ?, ?, ?)
    ");

    $update_stock = $conn->prepare("
        UPDATE products 
        SET stock_quantity = stock_quantity - ? 
        WHERE product_id = ?
    ");

    foreach ($cart_items as $item) {
        // Add order item
        $stmt->bind_param(
            "iiid",
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['price']
        );
        $stmt->execute();

        // Update stock
        $update_stock->bind_param(
            "ii",
            $item['quantity'],
            $item['product_id']
        );
        $update_stock->execute();
    }

    // Clear user's cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    // Update user's information
    $stmt = $conn->prepare("
        UPDATE users 
        SET first_name = ?, last_name = ?, phone = ?, address = ? 
        WHERE user_id = ?
    ");
    $stmt->bind_param(
        "ssssi",
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['phone'],
        $shipping_address,
        $user_id
    );
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully!',
        'order_id' => $order_id
    ]);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    $conn->close();
}
