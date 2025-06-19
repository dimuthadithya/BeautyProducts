<?php
$pageTitle = "Product Details";
$additionalCss = ["assets/css/product-details.css"];
include 'components/header.php';
?>

<?php include 'components/nav.php'; ?>

<!-- Product Details Section -->
<main class="product-details">
    <div class="product-container">
        <div class="product-images">
            <div class="main-image">
                <img
                    src="assets/images/product1.jpg"
                    alt="Product Image"
                    id="mainImage" />
            </div>
            <div class="thumbnail-images">
                <img
                    src="assets/images/product1.jpg"
                    alt="Thumbnail 1"
                    onclick="changeImage(this.src)" />
                <img
                    src="assets/images/product1-2.jpg"
                    alt="Thumbnail 2"
                    onclick="changeImage(this.src)" />
                <img
                    src="assets/images/product1-3.jpg"
                    alt="Thumbnail 3"
                    onclick="changeImage(this.src)" />
            </div>
        </div>
        <div class="product-info">
            <h1 class="product-title">Premium Beauty Product</h1>
            <div class="product-rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span>(4.5/5 - 128 reviews)</span>
            </div>
            <div class="product-price">
                <span class="current-price">$49.99</span>
                <span class="original-price">$59.99</span>
                <span class="discount">17% OFF</span>
            </div>
            <div class="product-description">
                <h3>Description</h3>
                <p>
                    Experience the ultimate in beauty care with our premium product.
                    This specially formulated solution provides deep nourishment and
                    lasting results. Perfect for all skin types and dermatologically
                    tested for your safety.
                </p>
            </div>
            <div class="product-variant">
                <h3>Size</h3>
                <div class="variant-options">
                    <button class="variant-btn active">30ml</button>
                    <button class="variant-btn">50ml</button>
                    <button class="variant-btn">100ml</button>
                </div>
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