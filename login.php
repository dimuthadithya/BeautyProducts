<?php
session_start();
require_once 'config/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $emailOrUsername = trim($_POST['username']);
  $password = $_POST['password'];

  if (empty($emailOrUsername) || empty($password)) {
    $error = "Please fill in all fields";
  } else {
    // Look up user by email using prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();

      // Verify password
      if (password_verify($password, $user['password_hash'])) {        // Store user info in session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['first_name'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect based on role
        if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
          $redirect = filter_var($_GET['redirect'], FILTER_SANITIZE_URL);
          // Only redirect to internal URLs
          if (parse_url($redirect, PHP_URL_HOST) === null) {
            header("Location: " . $redirect);
            exit;
          }
        }

        // If no valid redirect URL, use role-based redirect
        if ($user['role'] === 'admin') {
          header("Location: admin/dashboard.php");
        } else {
          header("Location: index.php");
        }
        exit;
      } else {
        $error = "Invalid email or password";
      }
    } else {
      $error = "Invalid email or password";
    }
    $stmt->close();
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login - Beauty Store</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/login.css" />
</head>

<body class="login-page">
  <div class="login-container">
    <div class="login-logo"><i class="fas fa-spa"></i> BeautyStore</div>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
    <form action="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . htmlspecialchars($_GET['redirect']) : ''; ?>" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Email Address</label>
        <input
          type="email"
          class="form-control"
          id="username"
          name="username"
          value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
          required />
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required />
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember" />
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-login">Login</button>
    </form>
    <div class="mt-3 text-center">
      <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-home"></i> Back to Home</a>
    </div>
    <div class="forgot-password">
      <a href="#">Forgot Password?</a>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>