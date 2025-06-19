<?php
$pageTitle = "My Profile";
$additionalCss = ["assets/css/profile.css"];
include 'components/header.php';
?>

<?php include 'components/nav.php'; ?>

<!-- Profile Section -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-header">
                        <img
                            src="https://via.placeholder.com/150"
                            alt="Profile"
                            class="profile-image" />
                        <h4>John Doe</h4>
                        <p>john.doe@example.com</p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                href="#personal-info"
                                data-bs-toggle="tab">
                                <i class="fas fa-user"></i> Personal Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#orders" data-bs-toggle="tab">
                                <i class="fas fa-shopping-bag"></i> My Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#addresses" data-bs-toggle="tab">
                                <i class="fas fa-map-marker-alt"></i> Addresses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wishlist" data-bs-toggle="tab">
                                <i class="fas fa-heart"></i> Wishlist
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#settings" data-bs-toggle="tab">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Profile Content -->
                <div class="tab-content">
                    <!-- Personal Information -->
                    <div class="tab-pane fade show active" id="personal-info">
                        <div class="profile-card">
                            <h4>Personal Information</h4>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" value="John" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" value="Doe" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        value="john.doe@example.com" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        value="(123) 456-7890" />
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Orders -->
                    <div class="tab-pane fade" id="orders">
                        <div class="profile-card">
                            <h4>My Orders</h4>
                            <div class="order-list">
                                <div class="order-item">
                                    <div class="order-header">
                                        <div>
                                            <h6>Order #ORD-2025-06-17</h6>
                                            <p class="text-muted">June 17, 2025</p>
                                        </div>
                                        <span class="badge bg-success">Delivered</span>
                                    </div>
                                    <div class="order-details">
                                        <p>2 Items • Total: LKR 76.47</p>
                                        <a
                                            href="order-details.php"
                                            class="btn btn-outline-primary btn-sm">View Details</a>
                                    </div>
                                </div>
                                <div class="order-item">
                                    <div class="order-header">
                                        <div>
                                            <h6>Order #ORD-2025-06-15</h6>
                                            <p class="text-muted">June 15, 2025</p>
                                        </div>
                                        <span class="badge bg-primary">Processing</span>
                                    </div>
                                    <div class="order-details">
                                        <p>1 Item • Total: LKR 34.99</p>
                                        <a
                                            href="order-details.php"
                                            class="btn btn-outline-primary btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="tab-pane fade" id="addresses">
                        <div class="profile-card">
                            <h4>My Addresses</h4>
                            <div class="address-list">
                                <div class="address-item">
                                    <div class="address-header">
                                        <h6>Home</h6>
                                        <span class="badge bg-primary">Default</span>
                                    </div>
                                    <p>
                                        John Doe<br />
                                        123 Beauty Street<br />
                                        New York, NY 10001<br />
                                        United States<br />
                                        Phone: (123) 456-7890
                                    </p>
                                    <div class="address-actions">
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                                <div class="address-item">
                                    <div class="address-header">
                                        <h6>Office</h6>
                                    </div>
                                    <p>
                                        John Doe<br />
                                        456 Work Avenue<br />
                                        New York, NY 10002<br />
                                        United States<br />
                                        Phone: (123) 456-7890
                                    </p>
                                    <div class="address-actions">
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i> Add New Address
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <div class="tab-pane fade" id="wishlist">
                        <div class="profile-card">
                            <h4>My Wishlist</h4>
                            <div class="wishlist-items">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="wishlist-item">
                                            <img
                                                src="https://via.placeholder.com/150"
                                                alt="Product"
                                                class="img-fluid" />
                                            <div class="wishlist-item-info">
                                                <h6>Natural Face Cream</h6>
                                                <p class="price">LKR 24.99</p>
                                                <div class="wishlist-actions">
                                                    <button class="btn btn-sm btn-primary">Add to Cart</button>
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="tab-pane fade" id="settings">
                        <div class="profile-card">
                            <h4>Account Settings</h4>
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Email Notifications</label>
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="orderUpdates"
                                            checked />
                                        <label class="form-check-label" for="orderUpdates">Order Updates</label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="promotions"
                                            checked />
                                        <label class="form-check-label" for="promotions">Promotions and Offers</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Change Password</label>
                                    <input
                                        type="password"
                                        class="form-control mb-2"
                                        placeholder="Current Password" />
                                    <input
                                        type="password"
                                        class="form-control mb-2"
                                        placeholder="New Password" />
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="Confirm New Password" />
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
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