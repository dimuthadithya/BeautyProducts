<?php
$pageTitle = "Shopping Cart";
$additionalCss = ["assets/css/cart.css"];
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
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img
                                    src="https://images.unsplash.com/photo-1580870069867-74c57ee1bb07"
                                    alt="Product"
                                    class="img-fluid" />
                            </div>
                            <div class="col-md-4">
                                <h5>Organic Lipstick</h5>
                                <p class="text-muted">Category: Makeup</p>
                            </div>
                            <div class="col-md-2">
                                <div class="quantity">
                                    <button class="btn-qty">-</button>
                                    <input type="number" value="2" min="1" />
                                    <button class="btn-qty">+</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <p class="price">LKR 19.99</p>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-remove">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h4>Order Summary</h4>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>LKR 64.97</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>LKR 5.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Tax</span>
                        <span>LKR 6.50</span>
                    </div>
                    <hr />
                    <div class="summary-item total">
                        <span>Total</span>
                        <span>LKR 76.47</span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary w-100">Proceed to Checkout</a>
                    <a href="shop.php" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>