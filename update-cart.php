<?php
require_once 'config/db_conn.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'update') {
        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Missing parameters']);
            exit;
        }

        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        if ($quantity < 1) {
            echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
            exit;
        }

        // Check stock availability
        $stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($quantity > $product['stock_quantity']) {
            echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
            exit;
        }

        // Update quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    } else if ($action === 'remove') {
        if (!isset($_POST['cart_id'])) {
            echo json_encode(['success' => false, 'message' => 'Missing cart ID']);
            exit;
        }

        $cart_id = (int)$_POST['cart_id'];

        // Delete cart item
        $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);
    }

    if ($stmt->execute()) {
        // Calculate new totals
        $stmt = $conn->prepare("
            SELECT SUM(c.quantity * p.price) as subtotal,
                   SUM(c.quantity) as cart_count
            FROM cart c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = ?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $totals = $result->fetch_assoc();
        $subtotal = (float)($totals['subtotal'] ?? 0);
        $shipping = 5.00;
        $tax = round($subtotal * 0.10, 2); // Round to 2 decimal places
        $total = round($subtotal + $shipping + $tax, 2); // Round final total to 2 decimal places

        echo json_encode([
            'success' => true,
            'message' => $action === 'update' ? 'Cart updated successfully' : 'Item removed successfully',
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'shipping' => number_format($shipping, 2, '.', ''),
            'tax' => number_format($tax, 2, '.', ''),
            'total' => number_format($total, 2, '.', ''),
            'cart_count' => (int)($totals['cart_count'] ?? 0)
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$stmt->close();
$conn->close();
