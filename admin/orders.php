<?php
require_once('../config/db_conn.php');
session_start();

// Get filter values
$status = isset($_GET['status']) ? $_GET['status'] : '';
$date_range = isset($_GET['date_range']) ? $_GET['date_range'] : 'last_7_days';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'latest';

// Build the query
$query = "SELECT o.*, u.first_name, u.last_name, u.email,
          GROUP_CONCAT(p.name SEPARATOR '||') as product_names,
          GROUP_CONCAT(p.image_url SEPARATOR '||') as product_images,
          GROUP_CONCAT(oi.quantity SEPARATOR '||') as quantities
          FROM orders o
          JOIN users u ON o.user_id = u.user_id
          JOIN order_items oi ON o.order_id = oi.order_id
          JOIN products p ON oi.product_id = p.product_id
          WHERE 1=1";

// Add status filter
if (!empty($status)) {
  $query .= " AND o.status = '" . mysqli_real_escape_string($conn, $status) . "'";
}

// Add date range filter
switch ($date_range) {
  case 'last_7_days':
    $query .= " AND o.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    break;
  case 'last_30_days':
    $query .= " AND o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    break;
  case 'last_month':
    $query .= " AND o.created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    break;
}



// Group by order_id to avoid duplicates
$query .= " GROUP BY o.order_id";

// Add sorting
switch ($sort_by) {
  case 'oldest':
    $query .= " ORDER BY o.created_at ASC";
    break;
  case 'amount_high':
    $query .= " ORDER BY o.total_amount DESC";
    break;
  case 'amount_low':
    $query .= " ORDER BY o.total_amount ASC";
    break;
  default: // latest
    $query .= " ORDER BY o.created_at DESC";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Orders - Beauty Store Admin</title>
  <?php include('include/head.php'); ?>
  <link rel="stylesheet" href="css/orders.css" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('include/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
      <?php
      $pageTitle = "Order Management";
      include('include/header.php');
      ?>

      <!-- Content Area -->
      <div class="content">
        <div class="container-fluid">
          <!-- Order Filters -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Order Status</label> <select class="form-select" name="status" onchange="updateFilters()">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="processing" <?php echo $status === 'processing' ? 'selected' : ''; ?>>Processing</option>
                    <option value="shipped" <?php echo $status === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                    <option value="delivered" <?php echo $status === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                    <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Date Range</label> <select class="form-select" name="date_range" onchange="updateFilters()">
                    <option value="last_7_days" <?php echo $date_range === 'last_7_days' ? 'selected' : ''; ?>>Last 7 Days</option>
                    <option value="last_30_days" <?php echo $date_range === 'last_30_days' ? 'selected' : ''; ?>>Last 30 Days</option>
                    <option value="last_month" <?php echo $date_range === 'last_month' ? 'selected' : ''; ?>>Last Month</option>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Sort By</label> <select class="form-select" name="sort_by" onchange="updateFilters()">
                    <option value="latest" <?php echo $sort_by === 'latest' ? 'selected' : ''; ?>>Latest First</option>
                    <option value="oldest" <?php echo $sort_by === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                    <option value="amount_high" <?php echo $sort_by === 'amount_high' ? 'selected' : ''; ?>>Amount: High to Low</option>
                    <option value="amount_low" <?php echo $sort_by === 'amount_low' ? 'selected' : ''; ?>>Amount: Low to High</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Orders Table -->
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table order-table">
                  <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Customer</th>
                      <th>Products</th>
                      <th>Date</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $products = explode('||', $row['product_names']);
                        $images = explode('||', $row['product_images']);
                        $quantities = explode('||', $row['quantities']);
                    ?>
                        <tr>
                          <td>#ORD-<?php echo str_pad($row['order_id'], 3, '0', STR_PAD_LEFT); ?></td>
                          <td>
                            <div><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></div>
                            <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                          </td>
                          <td>
                            <div class="d-flex align-items-center">
                              <img
                                src="../<?php echo htmlspecialchars($images[0]); ?>"
                                alt="<?php echo htmlspecialchars($products[0]); ?>"
                                class="me-2"
                                style="width: 50px; height: 50px; object-fit: cover;" />
                              <div>
                                <div><?php echo htmlspecialchars($products[0]); ?></div>
                                <small class="text-muted"><?php
                                                          echo count($products) > 1 ? '+ ' . (count($products) - 1) . ' more items' : '';
                                                          ?></small>
                              </div>
                            </div>
                          </td>
                          <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                          <td>LKR <?php echo number_format($row['total_amount'], 2); ?></td>
                          <td>
                            <span class="badge bg-<?php
                                                  echo match ($row['status']) {
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger',
                                                    default => 'secondary'
                                                  };
                                                  ?>">
                              <?php echo ucfirst($row['status']); ?>
                            </span>
                          </td>
                          <td>
                            <select class="form-select form-select-sm status-select" style="width: auto;"
                              data-order-id="<?php echo $row['order_id']; ?>"
                              data-current-status="<?php echo $row['status']; ?>">
                              <option value="pending" <?php echo $row['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                              <option value="processing" <?php echo $row['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                              <option value="shipped" <?php echo $row['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                              <option value="delivered" <?php echo $row['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                              <option value="cancelled" <?php echo $row['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                          </td>
                        </tr>
                      <?php
                      }
                    } else {
                      ?>
                      <tr>
                        <td colspan="7" class="text-center">No orders found</td>
                      </tr>
                    <?php
                    }                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Toast Container -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="statusToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function updateFilters() {
      const status = document.querySelector('select[name="status"]').value;
      const dateRange = document.querySelector('select[name="date_range"]').value;
      const sortBy = document.querySelector('select[name="sort_by"]').value;

      let url = window.location.pathname + '?';
      if (status) url += `status=${status}&`;
      if (dateRange) url += `date_range=${dateRange}&`;
      if (sortBy) url += `sort_by=${sortBy}&`;

      window.location.href = url.slice(0, -1); // Remove trailing &
    }

    // Initialize toast
    const statusToast = document.getElementById('statusToast');
    const toast = new bootstrap.Toast(statusToast);

    // Handle status changes
    document.querySelectorAll('.status-select').forEach(select => {
      select.addEventListener('change', async function() {
        const orderId = this.dataset.orderId;
        const currentStatus = this.dataset.currentStatus;
        const newStatus = this.value;

        try {
          const formData = new FormData();
          formData.append('order_id', orderId);
          formData.append('status', newStatus);

          const response = await fetch('update-order-status.php', {
            method: 'POST',
            body: formData
          });

          const data = await response.json();

          if (data.success) {
            // Update the status badge
            const statusBadge = this.closest('tr').querySelector('.badge');
            statusBadge.className = `badge bg-${
              newStatus === 'pending' ? 'warning' :
              newStatus === 'processing' ? 'info' :
              newStatus === 'shipped' ? 'primary' :
              newStatus === 'delivered' ? 'success' :
              newStatus === 'cancelled' ? 'danger' : 'secondary'
            }`;
            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

            // Show success toast
            statusToast.classList.remove('bg-danger');
            statusToast.classList.add('bg-success');
            statusToast.querySelector('.toast-body').textContent = 'Order status updated successfully';
            toast.show();

            // Update current status data attribute
            this.dataset.currentStatus = newStatus;
          } else {
            throw new Error(data.message);
          }
        } catch (error) {
          console.error('Error:', error);
          // Show error toast
          statusToast.classList.remove('bg-success');
          statusToast.classList.add('bg-danger');
          statusToast.querySelector('.toast-body').textContent = 'Failed to update order status';
          toast.show();

          // Revert the select to the previous value
          this.value = currentStatus;
        }
      });
    });
  </script>
</body>

</html>