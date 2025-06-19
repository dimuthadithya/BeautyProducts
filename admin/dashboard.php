<?php
require_once('../config/db_conn.php');
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
  exit();
}

// Fetch Total Orders
$orders_query = "SELECT COUNT(*) as total_orders, SUM(total_amount) as total_revenue FROM orders";
$orders_result = mysqli_query($conn, $orders_query);
$orders_data = mysqli_fetch_assoc($orders_result);
$total_orders = $orders_data['total_orders'];
$total_revenue = $orders_data['total_revenue'];

// Fetch Total Customers
$customers_query = "SELECT COUNT(*) as total_customers FROM users WHERE role = 'customer'";
$customers_result = mysqli_query($conn, $customers_query);
$customers_data = mysqli_fetch_assoc($customers_result);
$total_customers = $customers_data['total_customers'];

// Fetch Total Products
$products_query = "SELECT COUNT(*) as total_products FROM products";
$products_result = mysqli_query($conn, $products_query);
$products_data = mysqli_fetch_assoc($products_result);
$total_products = $products_data['total_products'];

// Fetch Recent Orders
$recent_orders_query = "SELECT o.*, u.first_name, u.last_name, p.name as product_name, p.image_url 
                       FROM orders o 
                       JOIN users u ON o.user_id = u.user_id 
                       JOIN order_items oi ON o.order_id = oi.order_id 
                       JOIN products p ON oi.product_id = p.product_id 
                       ORDER BY o.created_at DESC 
                       LIMIT 5";
$recent_orders_result = mysqli_query($conn, $recent_orders_query);

// Fetch Top Selling Products
$top_products_query = "SELECT p.name, COUNT(oi.product_id) as total_sold, 
                      SUM(oi.quantity * oi.price_per_unit) as revenue 
                      FROM products p 
                      JOIN order_items oi ON p.product_id = oi.product_id 
                      GROUP BY p.product_id 
                      ORDER BY total_sold DESC 
                      LIMIT 5";
$top_products_result = mysqli_query($conn, $top_products_query);

// Fetch Low Stock Products
$low_stock_query = "SELECT product_id, name, stock_quantity 
                    FROM products 
                    WHERE stock_quantity <= 10 
                    ORDER BY stock_quantity ASC 
                    LIMIT 5";
$low_stock_result = mysqli_query($conn, $low_stock_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - Beauty Store</title>
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="../assets/images/favicon_io/site.webmanifest">
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /> <?php include('include/head.php'); ?>
</head>

<body>
  <!-- Sidebar -->
  <?php include('include/sidebar.php'); ?>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="admin-header">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
          <h1 class="h3 mb-0">Dashboard</h1>
          <div class="admin-profile"> <span>Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <!-- Statistics -->
      <div class="row">
        <div class="col-md-3">
          <div class="stat-card">
            <i class="fas fa-shopping-bag stat-icon"></i>
            <h3><?php echo number_format($total_orders); ?></h3>
            <p class="text-muted mb-0">Total Orders</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <i class="fas fa-dollar-sign stat-icon"></i>
            <h3>LKR <?php echo number_format($total_revenue, 2); ?></h3>
            <p class="text-muted mb-0">Total Revenue</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <i class="fas fa-users stat-icon"></i>
            <h3><?php echo number_format($total_customers); ?></h3>
            <p class="text-muted mb-0">Total Customers</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <i class="fas fa-box stat-icon"></i>
            <h3><?php echo number_format($total_products); ?></h3>
            <p class="text-muted mb-0">Total Products</p>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Recent Orders</h5>
          <a href="orders.php" class="btn btn-primary btn-sm">View All</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Product</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($order = mysqli_fetch_assoc($recent_orders_result)): ?>
                  <tr>
                    <td>#ORD-<?php echo str_pad($order['order_id'], 3, '0', STR_PAD_LEFT); ?></td>
                    <td>
                      <img src="../<?php echo $order['image_url']; ?>" alt="<?php echo htmlspecialchars($order['product_name']); ?>" style="width: 50px; height: 50px; object-fit: cover;" />
                      <?php echo htmlspecialchars($order['product_name']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></td>
                    <td>LKR <?php echo number_format($order['total_amount'], 2); ?></td>
                    <td>
                      <span class="badge bg-<?php
                                            echo match ($order['status']) {
                                              'pending' => 'warning',
                                              'processing' => 'info',
                                              'shipped' => 'primary',
                                              'delivered' => 'success',
                                              'cancelled' => 'danger',
                                              default => 'secondary'
                                            };
                                            ?> status-badge">
                        <?php echo ucfirst($order['status']); ?>
                      </span>
                    </td>
                    <td>
                      <a href="order-details.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-primary">View</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Analytics Section -->
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Top Selling Products</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Sold</th>
                      <th>Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($product = mysqli_fetch_assoc($top_products_result)): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($product['total_sold']); ?></td>
                        <td>LKR <?php echo number_format($product['revenue'], 2); ?></td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Low Stock Alert</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Stock</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($product = mysqli_fetch_assoc($low_stock_result)): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><span class="text-danger"><?php echo $product['stock_quantity']; ?></span></td>
                        <td>
                          <a href="products.php?action=edit&id=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-warning">
                            Update Stock
                          </a>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>