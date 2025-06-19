<?php
function renderProductCard($product, $animation_delay = 0)
{
    $delay_attr = $animation_delay ? " data-aos-delay=\"$animation_delay\"" : "";
?>
    <div class="col-md-3 mb-4" data-aos="fade-up" <?php echo $delay_attr; ?>>
        <div class="card product-card">
            <img
                src="<?php echo htmlspecialchars($product['image_url']); ?>"
                class="card-img-top product-img"
                alt="<?php echo htmlspecialchars($product['name']); ?>" />
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                <p class="card-text">LKR <?php echo number_format($product['price'], 2); ?></p>
                <button onclick="addToCart(<?php echo $product['product_id']; ?>)" class="btn btn-outline-dark w-100">Add to Cart</button>
            </div>
        </div>
    </div>
<?php
}
