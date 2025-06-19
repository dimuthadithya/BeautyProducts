<?php
session_start();
$pageTitle = "Checkout";
$additionalCss = ["assets/css/checkout.css"];
require_once 'config/db_conn.php';
include 'components/header.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// Get user info
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get cart items
$stmt = $conn->prepare("
    SELECT c.quantity, p.name, p.price, p.stock_quantity
    FROM cart c 
    JOIN products p ON c.product_id = p.product_id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();

// Calculate totals
$subtotal = 0;
$items = [];
while ($item = $cart_items->fetch_assoc()) {
    $items[] = $item;
    $subtotal += $item['price'] * $item['quantity'];
}

if (empty($items)) {
    header('Location: cart.php');
    exit;
}

$shipping = 5.00;
$tax = round($subtotal * 0.10, 2);
$total = round($subtotal + $shipping + $tax, 2);
?>

<?php include 'components/nav.php'; ?>

<!-- Checkout Section -->
<section class="checkout-section">
    <div class="container">
        <h2 class="section-title">Checkout</h2>
        <div class="row">
            <div class="col-lg-8">
                <!-- Shipping Address -->
                <div class="checkout-form">
                    <h4>Shipping Address</h4>
                    <form id="checkoutForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $user['address'] ? explode(',', $user['address'])[0] : ''; ?>" required />
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" required />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="zip" class="form-control" required />
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Payment Information -->
                <div class="checkout-form mt-4">
                    <h4>Payment Method</h4>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" checked>
                            <label class="form-check-label" for="cashOnDelivery">
                                Cash on Delivery
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="order-summary">
                    <h4>Order Summary</h4>
                    <div class="order-items">
                        <?php foreach ($items as $item): ?>
                            <div class="order-item">
                                <span><?php echo htmlspecialchars($item['name']); ?> (<?php echo $item['quantity']; ?>x)</span>
                                <span>LKR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr />
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>LKR <?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>LKR <?php echo number_format($shipping, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Tax (10%)</span>
                        <span>LKR <?php echo number_format($tax, 2); ?></span>
                    </div>
                    <hr />
                    <div class="summary-item total">
                        <span>Total</span>
                        <span>LKR <?php echo number_format($total, 2); ?></span>
                    </div>
                    <button type="button" class="btn btn-primary w-100 mt-3" onclick="placeOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Checkout JS -->
<script src="assets/js/checkout.js"></script>
</body>

</html>