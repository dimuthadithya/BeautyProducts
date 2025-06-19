<?php
$pageTitle = "Shopping Cart";
$additionalCss = ["assets/css/cart.css"];
require_once 'config/db_conn.php';
include 'components/header.php';
?>

<?php include 'components/nav.php'; ?>

<!-- Cart Section -->
<section class="cart-section">
    <div class="container">
        <h2 class="section-title">Shopping Cart</h2>
        <div class="row">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="cart-items">
                    <?php
                    if (!isset($_SESSION['user_id'])) {
                        echo '<div class="alert alert-warning">Please <a href="login.php">login</a> to view your cart.</div>';
                    } else {
                        $user_id = $_SESSION['user_id'];
                        $stmt = $conn->prepare("
                            SELECT c.cart_id, c.quantity, p.product_id, p.name, p.price, p.image_url, cat.name as category_name 
                            FROM cart c 
                            JOIN products p ON c.product_id = p.product_id 
                            JOIN categories cat ON p.category_id = cat.category_id 
                            WHERE c.user_id = ?
                        ");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 0) {
                            echo '<div class="alert alert-info">Your cart is empty. <a href="shop.php">Continue shopping</a></div>';
                        } else {
                            $subtotal = 0;
                            while ($item = $result->fetch_assoc()) {
                                $itemTotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemTotal;
                    ?>
                                <div class="cart-item" data-cart-id="<?php echo $item['cart_id']; ?>">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img
                                                src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                                alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                class="img-fluid" />
                                        </div>
                                        <div class="col-md-4">
                                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                            <p class="text-muted">Category: <?php echo htmlspecialchars($item['category_name']); ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="quantity">
                                                <button class="btn-qty" onclick="updateQuantity(<?php echo $item['product_id']; ?>, 'decrease')">-</button>
                                                <input type="number" value="<?php echo $item['quantity']; ?>" min="1"
                                                    onchange="updateQuantity(<?php echo $item['product_id']; ?>, 'set', this.value)" />
                                                <button class="btn-qty" onclick="updateQuantity(<?php echo $item['product_id']; ?>, 'increase')">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="price">LKR <?php echo number_format($item['price'], 2); ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-remove" onclick="removeFromCart(<?php echo $item['cart_id']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            $_SESSION['cart_subtotal'] = $subtotal;
                            $shipping = 5.00; // Fixed shipping cost
                            $tax = $subtotal * 0.10; // 10% tax
                            $total = $subtotal + $shipping + $tax;
                            ?>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h4>Order Summary</h4>
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
                    <?php if ($subtotal > 0) { ?>
                        <a href="checkout.php" class="btn btn-primary w-100">Proceed to Checkout</a>
                    <?php } ?>
                    <a href="shop.php" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                </div>
        <?php
                        }
                    }
        ?>
            </div>
        </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>