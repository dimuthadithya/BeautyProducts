<?php
session_start();
$pageTitle = "My Profile";
$additionalCss = ["assets/css/profile.css"];
require_once 'config/db_conn.php';
include 'components/header.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get user's orders
$stmt = $conn->prepare("
    SELECT o.*, 
           (SELECT COUNT(*) FROM order_items WHERE order_id = o.order_id) as item_count
    FROM orders o 
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

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

<!-- Profile Section -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-header">
                        <img
                            src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['first_name'] . ' ' . $user['last_name']); ?>&background=random"
                            alt="Profile"
                            class="profile-image" />
                        <h4><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
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
                    </ul>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Profile Content -->
                <div class="tab-content"> <!-- Personal Information -->
                    <div class="tab-pane fade show active" id="personal-info">
                        <div class="profile-card">
                            <h4>Personal Information</h4>
                            <form id="profileForm">
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
                                    <input
                                        type="email"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['email']); ?>"
                                        readonly />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input
                                        type="tel"
                                        name="phone"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['phone']); ?>" />
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
                                <?php if ($orders->num_rows === 0): ?>
                                    <div class="text-center py-4">
                                        <p class="text-muted">You haven't placed any orders yet.</p>
                                        <a href="shop.php" class="btn btn-primary">Start Shopping</a>
                                    </div>
                                <?php else: ?>
                                    <?php while ($order = $orders->fetch_assoc()): ?>
                                        <div class="order-item">
                                            <div class="order-header">
                                                <div>
                                                    <h6>Order #<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></h6>
                                                    <p class="text-muted"><?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                                                </div>
                                                <span class="badge bg-<?php echo $status_colors[$order['status']]; ?>">
                                                    <?php echo ucfirst($order['status']); ?>
                                                </span>
                                            </div>
                                            <div class="order-details">
                                                <p><?php echo $order['item_count']; ?> <?php echo $order['item_count'] === 1 ? 'Item' : 'Items'; ?> • Total: LKR <?php echo number_format($order['total_amount'], 2); ?></p>
                                                <a href="order-details.php?id=<?php echo $order['order_id']; ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div> <!-- Addresses -->
                    <div class="tab-pane fade" id="addresses">
                        <div class="profile-card">
                            <h4>My Addresses</h4>
                            <div class="address-list">
                                <?php if ($user['address']): ?>
                                    <div class="address-item">
                                        <div class="address-header">
                                            <h6>Default Address</h6>
                                            <span class="badge bg-primary">Default</span>
                                        </div>
                                        <p>
                                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?><br />
                                            <?php echo nl2br(htmlspecialchars($user['address'])); ?><br />
                                            Phone: <?php echo htmlspecialchars($user['phone']); ?>
                                        </p>
                                        <div class="address-actions">
                                            <button class="btn btn-sm btn-outline-primary" onclick="editAddress()">Edit</button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <p class="text-muted">You haven't added any addresses yet.</p>
                                        <button class="btn btn-primary" onclick="editAddress()">
                                            <i class="fas fa-plus"></i> Add Address
                                        </button>
                                    </div>
                                <?php endif; ?>
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

<script>
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        // Disable submit button and show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Saving...
    `;

        fetch('update-profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                    });

                    // Highlight missing fields if any
                    if (data.missing_fields) {
                        data.missing_fields.forEach(field => {
                            const input = this.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.'
                });
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
    });

    function editAddress() {
        Swal.fire({
            title: 'Update Address',
            html: `
            <form id="addressForm">
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" name="address" rows="3" required>${document.querySelector('.address-item p')?.textContent.trim() || ''}</textarea>
                </div>
            </form>
        `,
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const formData = new FormData(document.getElementById('addressForm'));
                return fetch('update-address.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            throw new Error(data.message);
                        }
                        return data;
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error.message);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: result.value.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>