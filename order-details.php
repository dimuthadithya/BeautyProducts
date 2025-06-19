<?php
session_start();
$pageTitle = "Order Details";
$additionalCss = ["assets/css/order-details.css"];
require_once 'config/db_conn.php';
include 'components/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// Check if order ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: profile.php');
    exit;
}

$order_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Get order information
$stmt = $conn->prepare("
    SELECT o.*, u.first_name, u.last_name
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    WHERE o.order_id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header('Location: profile.php');
    exit;
}

// Get order items
$stmt = $conn->prepare("
    SELECT oi.*, p.name, p.image_url, c.name as category_name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result();

// Calculate totals
$subtotal = 0;
$items = [];
while ($item = $order_items->fetch_assoc()) {
    $items[] = $item;
    $subtotal += $item['price_per_unit'] * $item['quantity'];
}

$shipping = 5.00;
$tax = round($subtotal * 0.10, 2);
$total = round($subtotal + $shipping + $tax, 2);

// Status badge colors
$status_colors = [
    'pending' => 'warning',
    'processing' => 'info',
    'shipped' => 'primary',
    'delivered' => 'success',
    'cancelled' => 'danger'
];
?>

<?php include 'components/nav.php'; ?>

<!-- Order Details Section -->
<section class="order-details-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Order Details</h2>
            <a href="profile.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Profile
            </a>
        </div>

        <!-- Order Information -->
        <div class="order-info-card">
            <div class="row">
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Order Number</h6>
                        <p>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Order Date</h6>
                        <p><?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Status</h6>
                        <span class="badge bg-<?php echo $status_colors[$order['status']]; ?>"><?php echo ucfirst($order['status']); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Total Amount</h6>
                        <p>LKR <?php echo number_format($order['total_amount'], 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8">
                <!-- Order Items -->
                <div class="order-items-card">
                    <h4>Order Items</h4>
                    <?php foreach ($items as $item): ?>
                        <div class="order-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img
                                        src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                        alt="<?php echo htmlspecialchars($item['name']); ?>"
                                        class="img-fluid" />
                                </div>
                                <div class="col-md-6">
                                    <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                    <p class="text-muted">Category: <?php echo htmlspecialchars($item['category_name']); ?></p>
                                </div>
                                <div class="col-md-2">
                                    <p class="quantity">Qty: <?php echo $item['quantity']; ?></p>
                                </div>
                                <div class="col-md-2">
                                    <p class="price">LKR <?php echo number_format($item['price_per_unit'] * $item['quantity'], 2); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="order-summary mt-4">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="summary-item d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span>LKR <?php echo number_format($subtotal, 2); ?></span>
                                </div>
                                <div class="summary-item d-flex justify-content-between">
                                    <span>Shipping:</span>
                                    <span>LKR <?php echo number_format($shipping, 2); ?></span>
                                </div>
                                <div class="summary-item d-flex justify-content-between">
                                    <span>Tax (10%):</span>
                                    <span>LKR <?php echo number_format($tax, 2); ?></span>
                                </div>
                                <hr>
                                <div class="summary-item d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong>LKR <?php echo number_format($total, 2); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Delivery Information -->
                <div class="delivery-info-card">
                    <h4>Delivery Information</h4>
                    <div class="delivery-address">
                        <h6>Shipping Address</h6>
                        <p>
                            <?php
                            echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) . '<br>';
                            echo nl2br(htmlspecialchars($order['shipping_address']));
                            ?>
                        </p>
                    </div>
                    <hr />
                    <div class="delivery-timeline">
                        <h6>Order Status Timeline</h6>
                        <?php
                        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                        $current_status_index = array_search($order['status'], $statuses);

                        foreach ($statuses as $index => $status):
                            $is_completed = $index <= $current_status_index;
                            if ($order['status'] !== 'cancelled' || $status === 'pending'):
                        ?>
                                <div class="timeline-item <?php echo $is_completed ? 'completed' : ''; ?>">
                                    <i class="fas <?php echo $is_completed ? 'fa-check-circle' : 'fa-circle'; ?>"></i>
                                    <div>
                                        <h6><?php echo ucfirst($status); ?></h6>
                                        <?php if ($is_completed && $status === $order['status']): ?>
                                            <p><?php echo date('F j, Y - g:i A', strtotime($order['created_at'])); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endif;
                        endforeach;

                        if ($order['status'] === 'cancelled'):
                            ?>
                            <div class="timeline-item completed">
                                <i class="fas fa-times-circle text-danger"></i>
                                <div>
                                    <h6 class="text-danger">Cancelled</h6>
                                    <p><?php echo date('F j, Y - g:i A', strtotime($order['created_at'])); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>