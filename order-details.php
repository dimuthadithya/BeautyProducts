<?php
$pageTitle = "Order Details";
$additionalCss = ["assets/css/order-details.css"];
include 'components/header.php';
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
                        <p>#ORD-2025-06-17</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Order Date</h6>
                        <p>June 17, 2025</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Status</h6>
                        <span class="badge bg-success">Delivered</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item">
                        <h6>Total Amount</h6>
                        <p>LKR 76.47</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8">
                <!-- Order Items -->
                <div class="order-items-card">
                    <h4>Order Items</h4>
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img
                                    src="https://via.placeholder.com/100"
                                    alt="Product"
                                    class="img-fluid" />
                            </div>
                            <div class="col-md-6">
                                <h5>Natural Face Cream</h5>
                                <p class="text-muted">Category: Skincare</p>
                            </div>
                            <div class="col-md-2">
                                <p class="quantity">Qty: 1</p>
                            </div>
                            <div class="col-md-2">
                                <p class="price">LKR 24.99</p>
                            </div>
                        </div>
                    </div>
                    <div class="order-item">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img
                                    src="https://via.placeholder.com/100"
                                    alt="Product"
                                    class="img-fluid" />
                            </div>
                            <div class="col-md-6">
                                <h5>Organic Lipstick</h5>
                                <p class="text-muted">Category: Makeup</p>
                            </div>
                            <div class="col-md-2">
                                <p class="quantity">Qty: 2</p>
                            </div>
                            <div class="col-md-2">
                                <p class="price">LKR 39.98</p>
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
                            John Doe<br />
                            123 Beauty Street<br />
                            New York, NY 10001<br />
                            United States
                        </p>
                    </div>
                    <hr />
                    <div class="delivery-timeline">
                        <h6>Delivery Timeline</h6>
                        <div class="timeline-item completed">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h6>Order Placed</h6>
                                <p>June 17, 2025 - 10:30 AM</p>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h6>Order Processed</h6>
                                <p>June 17, 2025 - 2:15 PM</p>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h6>Shipped</h6>
                                <p>June 18, 2025 - 9:00 AM</p>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h6>Delivered</h6>
                                <p>June 20, 2025 - 2:30 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>