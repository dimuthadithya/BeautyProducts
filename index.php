<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beauty Store - Your Beauty Destination</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/nav.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.html">BeautyStore</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.html">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact</a>
            </li>
            <li class="nav-item shopping-cart">
              <a class="nav-link" href="cart.html"
                ><i class="fas fa-shopping-cart"></i
              ></a>
              <span class="cart-count">0</span>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <div class="row">
          <div class="col-md-8" data-aos="fade-right">
            <h1 class="display-4 mb-4">Discover Your Natural Beauty</h1>
            <p class="lead mb-4">
              Experience premium beauty products that enhance your natural
              beauty. Shop our curated collection of skincare, makeup, and
              beauty essentials.
            </p>
            <a href="shop.html" class="btn btn-lg btn-light">Shop Now</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="py-5">
      <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Featured Products</h2>
        <div class="row">
          <!-- Product 1 -->
          <div class="col-md-3" data-aos="fade-up">
            <div class="card product-card">
              <img
                src="https://images.unsplash.com/photo-1571875257727-256c39da42af"
                class="card-img-top product-img"
                alt="Product"
              />
              <div class="card-body">
                <h5 class="card-title">Natural Moisturizer</h5>
                <p class="card-text">LKR 24.99</p>
                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
              </div>
            </div>
          </div>
          <!-- Product 2 -->
          <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card product-card">
              <img
                src="https://images.unsplash.com/photo-1596462502278-27bfdc403348"
                class="card-img-top product-img"
                alt="Organic Lipstick"
              />
              <div class="card-body">
                <h5 class="card-title">Organic Lipstick</h5>
                <p class="card-text">LKR 19.99</p>
                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
              </div>
            </div>
          </div>
          <!-- Product 3 -->
          <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card product-card">
              <img
                src="https://images.unsplash.com/photo-1571875257727-256c39da42af"
                class="card-img-top product-img"
                alt="Product"
              />
              <div class="card-body">
                <h5 class="card-title">Night Cream</h5>
                <p class="card-text">LKR 34.99</p>
                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
              </div>
            </div>
          </div>
          <!-- Product 4 -->
          <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card product-card">
              <img
                src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be"
                class="card-img-top product-img"
                alt="Face Serum"
              />
              <div class="card-body">
                <h5 class="card-title">Face Serum</h5>
                <p class="card-text">LKR 29.99</p>
                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories -->
    <section class="py-5 bg-light">
      <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Shop by Category</h2>
        <div class="row">
          <!-- Category 1 -->
          <div class="col-md-4 mb-4" data-aos="fade-up">
            <div class="category-card">
              <img
                src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
                alt="Skincare"
                class="category-img"
              />
              <div class="category-overlay">
                <span>Skincare</span>
              </div>
            </div>
          </div>
          <!-- Category 2 -->
          <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="category-card">
              <img
                src="https://images.unsplash.com/photo-1571875257727-256c39da42af"
                alt="Makeup"
                class="category-img"
              />
              <div class="category-overlay">
                <span>Makeup</span>
              </div>
            </div>
          </div>
          <!-- Category 3 -->
          <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="category-card">
              <img
                src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e"
                alt="Hair Care"
                class="category-img"
              />
              <div class="category-overlay">
                <span>Hair Care</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4">
            <h3 class="footer-heading">BeautyStore</h3>
            <p>
              Your one-stop destination for all beauty needs. We provide
              high-quality beauty products that enhance your natural beauty.
            </p>
            <div class="social-links">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <h3 class="footer-heading">Quick Links</h3>
            <ul class="footer-links">
              <li><a href="index.html">Home</a></li>
              <li><a href="shop.html">Shop</a></li>
              <li><a href="about.html">About</a></li>
              <li><a href="contact.html">Contact</a></li>
            </ul>
          </div>
          <div class="col-md-4 mb-4">
            <h3 class="footer-heading">Contact Info</h3>
            <ul class="footer-links">
              <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
              <li><i class="fas fa-envelope me-2"></i> info@beautystore.com</li>
              <li>
                <i class="fas fa-map-marker-alt me-2"></i> 123 Beauty Street, NY
                10001
              </li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 BeautyStore. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 1000,
        once: true
      });
    </script>
  </body>
</html>
