<?php
$pageTitle = "Your Beauty Destination";
$additionalCss = ["assets/css/home.css"];
include 'components/header.php';
?><?php include 'components/nav.php'; ?>

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
            alt="Product" />
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
            alt="Organic Lipstick" />
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
            alt="Product" />
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
            alt="Face Serum" />
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
            class="category-img" />
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
            class="category-img" />
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
            class="category-img" />
          <div class="category-overlay">
            <span>Hair Care</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><?php include 'components/footer.php'; ?>
</body>

</html>