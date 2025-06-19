<?php
if (!isset($_SESSION)) {
    session_start();
}

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}
?>
<!-- Header -->
<div class="admin-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h1 class="h3 mb-0 ms-3"><?php echo $pageTitle; ?></h1>
            </div>
            <div class="admin-profile">
                <span>Welcome, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin'; ?></span>
            </div>
        </div>
    </div>
</div>