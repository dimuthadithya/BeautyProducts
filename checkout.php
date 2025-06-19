<?php
$pageTitle = "Checkout";
$additionalCss = ["assets/css/checkout.css"];
include 'components/header.php';
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
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" required />
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" required />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" required />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" required />
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Payment Information -->
                <div class="checkout-form mt-4">
                    <h4>Payment Information</h4>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Card Number</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="1234 5678 9012 3456"
                                required />
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expiration Date</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="MM/YY"
                                    required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CVV</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="123"
                                    required />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="order-summary">
                    <h4>Order Summary</h4>
                    <div class="order-items">
                        <div class="order-item">
                            <span>Natural Face Cream (1x)</span>
                            <span>LKR 24.99</span>
                        </div>
                        <div class="order-item">
                            <span>Organic Lipstick (2x)</span>
                            <span>LKR 39.98</span>
                        </div>
                    </div>
                    <hr />
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
                    <button class="btn btn-primary w-100 mt-3">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>