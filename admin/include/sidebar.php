<div class="sidebar">
  <a href="dashboard.php" class="sidebar-brand">
    <i class="fas fa-spa"></i> BeautyStore
  </a> <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
  <nav>
    <a href="dashboard.php" class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>">
      <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="products.php" class="nav-link <?php echo $current_page === 'products.php' ? 'active' : ''; ?>">
      <i class="fas fa-box"></i> Products
    </a>
    <a href="categories.php" class="nav-link <?php echo $current_page === 'categories.php' ? 'active' : ''; ?>">
      <i class="fas fa-tags"></i> Categories
    </a>
    <a href="orders.php" class="nav-link <?php echo $current_page === 'orders.php' ? 'active' : ''; ?>">
      <i class="fas fa-shopping-cart"></i> Orders
    </a>
    <a href="customers.php" class="nav-link <?php echo $current_page === 'customers.php' ? 'active' : ''; ?>">
      <i class="fas fa-users"></i> Customers
    </a>
    <a href="../config/logout.php" class="nav-link">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </nav>
</div>