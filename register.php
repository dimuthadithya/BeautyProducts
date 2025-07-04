<?php
include 'config/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstName = $_POST['firstName'];
  $lastName  = $_POST['lastName'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $password  = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  if ($password !== $confirmPassword) {
    die("Passwords do not match.");
  }

  // Check if email already exists
  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    die("Email already registered.");
  }

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO users (first_name, last_name, email, password_hash, phone)
        VALUES ('$firstName', '$lastName', '$email', '$passwordHash', '$phone')";

  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Beauty Store</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/nav.css" />
  <link rel="stylesheet" href="assets/css/auth.css" />
</head>

<body>

  <!-- Registration Section -->
  <section class="auth-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="auth-card">
            <div class="auth-header text-center">
              <h2>Create an Account</h2>
              <p>Join BeautyStore to discover amazing beauty products</p>
            </div>
            <form id="registerForm" class="auth-form" action="register.php" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input
                      type="text"
                      id="firstName"
                      name="firstName"
                      class="form-control"
                      required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input
                      type="text"
                      id="lastName"
                      name="lastName"
                      class="form-control"
                      required />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control"
                  required />
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <div class="password-input">
                  <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required />
                  <i class="fas fa-eye password-toggle"></i>
                </div>
              </div>
              <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="password-input">
                  <input
                    type="password"
                    id="confirmPassword"
                    name="confirmPassword"
                    class="form-control"
                    required />
                  <i class="fas fa-eye password-toggle"></i>
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="terms"
                    required />
                  <label class="form-check-label" for="terms">
                    I agree to the <a href="#">Terms of Service</a> and
                    <a href="#">Privacy Policy</a>
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100">
                Create Account
              </button>
            </form>
            <div class="mt-3 text-center">
              <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-home"></i> Back to Home</a>
            </div>
            <div class="auth-footer">
              <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script>
    // Password visibility toggle
    document.querySelectorAll('.password-toggle').forEach((toggle) => {
      toggle.addEventListener('click', (e) => {
        const input = e.target.previousElementSibling;
        const type =
          input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        e.target.classList.toggle('fa-eye');
        e.target.classList.toggle('fa-eye-slash');
      });
    });

    // Form validation and submission
    document
      .getElementById('registerForm')
      .addEventListener('submit', (e) => {


        const password = document.getElementById('password').value;
        const confirmPassword =
          document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
          e.preventDefault();
          alert('Passwords do not match!');
          return;
        }


        // Redirect to login page after successful registration
        // window.location.href = 'login.html';
      });
  </script>
</body>

</html>