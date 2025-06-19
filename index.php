<?php
$pageTitle = "Your Beauty Destination";
$additionalCss = ["assets/css/home.css"];
require_once 'config/db_conn.php';
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
        <a href="shop.php" class="btn btn-lg btn-light">Shop Now</a>
      </div>
    </div>
  </div>
</section>

<!-- Featured Products -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Featured Products</h2>
    <div class="row">
      <?php
      require_once 'components/product-card.php';

      // Get 4 random products for featured section
      $query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
      $result = mysqli_query($conn, $query);

      $delay = 0;
      while ($product = mysqli_fetch_assoc($result)) {
        renderProductCard($product, $delay);
        $delay += 100;
      }
      ?>
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