<?php
require_once 'config/db_conn.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.category_id 
          WHERE p.product_id = $product_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: shop.php");
    exit;
}

$product = mysqli_fetch_assoc($result);
$pageTitle = $product['name'] . " - Product Details";
$additionalCss = ["assets/css/product-details.css"];
include 'components/header.php';
?>

<?php include 'components/nav.php'; ?>

<!-- Product Details Section -->
<main class="product-details mt-5">
    <div class="product-container">
        <div class="product-images mt-5">
            <div class="main-image">
                <img
                    src="<?php echo htmlspecialchars($product['image_url']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    id="mainImage" />
            </div>
        </div>
        <div class="product-info">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="shop.php">Shop</a></li>
                    <li class="breadcrumb-item"><a href="shop.php?category=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
                </ol>
            </nav>
            <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="product-category mb-3">
                <span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span>
            </div>
            <div class="product-price mb-4">
                <span class="current-price">LKR <?php echo number_format($product['price'], 2); ?></span>
            </div>
            <?php if ($product['stock_quantity'] > 0): ?>
                <div class="stock-info mb-3 text-success">
                    <i class="fas fa-check-circle"></i> In Stock (<?php echo $product['stock_quantity']; ?> available)
                </div>
            <?php else: ?>
                <div class="stock-info mb-3 text-danger">
                    <i class="fas fa-times-circle"></i> Out of Stock
                </div>
            <?php endif; ?>
            <div class="product-description">
                <h3>Description</h3>
                <p>
                    Experience the ultimate in beauty care with our premium product.
                    This specially formulated solution provides deep nourishment and
                    lasting results. Perfect for all skin types and dermatologically
                    tested for your safety.
                </p>
            </div>
            <div class="quantity-selector">
                <h3>Quantity</h3>
                <div class="quantity-controls">
                    <button onclick="decrementQuantity()">-</button>
                    <input type="number" id="quantity" value="1" min="1" max="10" />
                    <button onclick="incrementQuantity()">+</button>
                </div>
            </div>
            <div class="product-actions"> <button onclick="addToCart(<?php echo isset($_GET['id']) ? $_GET['id'] : 1; ?>)" class="add-to-cart-btn">Add to Cart</button>
                <button onclick="buyNow(<?php echo isset($_GET['id']) ? $_GET['id'] : 1; ?>)" class="buy-now-btn">Buy Now</button>
            </div>
            <div class="additional-info">
                <div class="info-item">
                    <i class="fas fa-truck"></i>
                    <span>Free shipping on orders over $50</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-undo"></i>
                    <span>30-day return policy</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure checkout</span>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function incrementQuantity() {
        const input = document.getElementById('quantity');
        if (input.value < 10) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>

<?php include 'components/footer.php'; ?>
</body>

</html>