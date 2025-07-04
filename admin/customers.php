<?php
require_once('../config/db_conn.php');
session_start();

// Delete User
if (isset($_GET['delete_user']) && isset($_GET['user_id'])) {
  $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

  // First check if user has any orders
  $check_orders = "SELECT COUNT(*) as count FROM orders WHERE user_id = $user_id";
  $result = mysqli_query($conn, $check_orders);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    $_SESSION['message'] = "Cannot delete user: They have existing orders!";
    $_SESSION['msg_type'] = "danger";
  } else {
    // Check and delete from cart first
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

    // Delete the user
    $query = "DELETE FROM users WHERE user_id = $user_id";
    if (mysqli_query($conn, $query)) {
      $_SESSION['message'] = "Customer deleted successfully!";
      $_SESSION['msg_type'] = "success";
    } else {
      $_SESSION['message'] = "Error deleting customer!";
      $_SESSION['msg_type'] = "danger";
    }
  }
  header("Location: customers.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customers - Beauty Store Admin</title> <?php include('include/head.php'); ?>
  <link rel="stylesheet" href="css/sidebar.css" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="css/customers.css" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('include/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
      <?php
      $pageTitle = "Customer Management";
      include('include/header.php');
      ?>

      <!-- Content Area -->
      <div class="content">
        <div class="container-fluid">
          <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
              <?php
              echo $_SESSION['message'];
              unset($_SESSION['message']);
              unset($_SESSION['msg_type']);
              ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Customers Table -->
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Role</th>
                      <th>Joined Date</th>
                      <th>Orders</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT u.*, 
                                         COUNT(DISTINCT o.order_id) as total_orders,
                                         SUM(o.total_amount) as total_spent
                                         FROM users u
                                         LEFT JOIN orders o ON u.user_id = o.user_id
                                         GROUP BY u.user_id
                                         ORDER BY u.created_at DESC";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)):
                      $role_badge = $row['role'] == 'admin' ?
                        '<span class="badge bg-danger">Admin</span>' :
                        '<span class="badge bg-success">Customer</span>';
                    ?>
                      <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td>
                          <div>
                            <h6 class="mb-0"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h6>
                            <?php if ($row['address']): ?>
                              <small class="text-muted"><?php echo htmlspecialchars($row['address']); ?></small>
                            <?php endif; ?>
                          </div>
                        </td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo $row['phone'] ? htmlspecialchars($row['phone']) : '-'; ?></td>
                        <td><?php echo $role_badge; ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                        <td>
                          <?php if ($row['total_orders'] > 0): ?>
                            <div>
                              <strong><?php echo $row['total_orders']; ?></strong> orders<br>
                              <small class="text-muted">LKR <?php echo number_format($row['total_spent'], 2); ?> total spent</small>
                            </div>
                          <?php else: ?>
                            <span class="text-muted">No orders</span>
                          <?php endif; ?>
                        </td>
                        <td>

                          <?php if ($row['role'] != 'admin'): ?>
                            <a class="btn btn-danger btn-sm delete-user"
                              href="customers.php?delete_user=true&user_id=<?php echo $row['user_id']; ?>">
                              <i class="fas fa-trash"></i>
                            </a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>

          <!-- Customer Details Modal -->
          <div class="modal fade" id="customerDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Customer Details</h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-4 text-center">
                      <img
                        src="https://via.placeholder.com/150"
                        alt="Customer"
                        class="rounded-circle mb-3" />
                      <h5>John Doe</h5>
                      <p class="text-muted">Customer since June 2025</p>
                    </div>
                    <div class="col-md-8">
                      <h6>Personal Information</h6>
                      <div class="mb-3">
                        <p class="mb-1"><strong>Email:</strong> john@example.com</p>
                        <p class="mb-1"><strong>Phone:</strong> +1 234 567 890</p>
                        <p class="mb-1">
                          <strong>Address:</strong> 123 Main St, New York, NY 10001
                        </p>
                      </div>


                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                  </button>
                  <button type="button" class="btn btn-primary">Send Message</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Bootstrap JS -->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>