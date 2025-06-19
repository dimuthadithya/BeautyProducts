<?php
$pageTitle = "Shop";
$additionalCss = ["assets/css/shop.css"];
include 'components/header.php';
?>

<?php include 'components/nav.php'; ?>

<!-- Shop Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="category-filter" data-aos="fade-right">
                    <h4>Categories</h4>
                    <ul class="category-list">
                        <li>
                            <label> <input type="checkbox" checked /> Skincare </label>
                        </li>
                        <li>
                            <label> <input type="checkbox" /> Makeup </label>
                        </li>
                        <li>
                            <label> <input type="checkbox" /> Hair Care </label>
                        </li>
                        <li>
                            <label> <input type="checkbox" /> Body Care </label>
                        </li>
                        <li>
                            <label> <input type="checkbox" /> Fragrances </label>
                        </li>
                    </ul>

                    <h4 class="mt-4">Price Range</h4>
                    <div class="price-range">
                        <input
                            type="range"
                            class="form-range"
                            min="0"
                            max="200"
                            value="100" />
                        <div class="d-flex justify-content-between">
                            <span>LKR 0</span>
                            <span>LKR 200</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Our Products</h2>
                    <select class="form-select" style="width: auto">
                        <option>Sort by: Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                    </select>
                </div>
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="card product-card">
                            <img
                                src="https://images.unsplash.com/photo-1571875257727-256c39da42af"
                                class="card-img-top product-img"
                                alt="Product" />
                            <div class="card-body">
                                <h5 class="card-title">Natural Moisturizer</h5>
                                <p class="card-text">LKR 24.99</p>
                                <button onclick="addToCart(1)" class="btn btn-outline-dark w-100">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card product-card">
                            <img
                                src="https://images.unsplash.com/photo-1586495777744-4413f21062fa"
                                class="card-img-top product-img"
                                alt="Organic Lipstick" />
                            <div class="card-body">
                                <h5 class="card-title">Organic Lipstick</h5>
                                <p class="card-text">LKR 19.99</p>
                                <button onclick="addToCart(2)" class="btn btn-outline-dark w-100">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 3 -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card product-card">
                            <img
                                src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
                                class="card-img-top product-img"
                                alt="Product" />
                            <div class="card-body">
                                <h5 class="card-title">Night Cream</h5>
                                <p class="card-text">LKR 34.99</p>
                                <button onclick="addToCart(3)" class="btn btn-outline-dark w-100">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- More products... -->
                    <!-- Product 4 -->
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="card product-card">
                            <img
                                src="https://images.unsplash.com/photo-1571875257727-256c39da42af"
                                class="card-img-top product-img"
                                alt="Product" />
                            <div class="card-body">
                                <h5 class="card-title">Face Serum</h5>
                                <p class="card-text">LKR 29.99</p>
                                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <!-- Product 5 -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card product-card">
                            <img
                                src="https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d"
                                class="card-img-top product-img"
                                alt="Hair Oil" />
                            <div class="card-body">
                                <h5 class="card-title">Hair Oil</h5>
                                <p class="card-text">LKR 22.99</p>
                                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <!-- Product 6 -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card product-card">
                            <img
                                src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
                                class="card-img-top product-img"
                                alt="Product" />
                            <div class="card-body">
                                <h5 class="card-title">Body Lotion</h5>
                                <p class="card-text">LKR 26.99</p>
                                <a href="#" class="btn btn-outline-dark w-100">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
</body>

</html>