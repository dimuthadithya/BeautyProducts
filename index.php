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
      <?php
      // Get all categories
      $query = "SELECT * FROM categories ORDER BY name";
      $result = mysqli_query($conn, $query);

      $delay = 0;
      while ($category = mysqli_fetch_assoc($result)) {
        // Convert category name to lowercase and remove spaces for image filename
        $image_filename = strtolower(str_replace(' ', '', $category['name'])) . '.jpg';
      ?>
        <div class="col-md-4 mb-4" data-aos="fade-up" <?php echo $delay ? "data-aos-delay=\"$delay\"" : ''; ?>>
          <a href="shop.php?category=<?php echo $category['category_id']; ?>" class="text-decoration-none">
            <div class="category-card">
              <img
                src="assets/images/categories/<?php echo $image_filename; ?>"
                alt="<?php echo htmlspecialchars($category['name']); ?>"
                class="category-img" />
              <div class="category-overlay">
                <span><?php echo htmlspecialchars($category['name']); ?></span>
              </div>
            </div>
          </a>
        </div>
      <?php
        $delay += 100;
      }
      ?>
    </div>
  </div>
</section><?php include 'components/footer.php'; ?>
</body>

</html>