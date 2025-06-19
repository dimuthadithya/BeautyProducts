<?php
require_once 'config/db_conn.php';
$pageTitle = "Shop";
$additionalCss = ["assets/css/shop.css", "assets/css/categories.css"];
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
                        <?php $category_query = "SELECT * FROM categories ORDER BY name";
                        $category_result = mysqli_query($conn, $category_query);

                        if (!$category_result) {
                            echo "Category Query Error: " . mysqli_error($conn);
                        }

                        // Get current category filter
                        $current_category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

                        // Add "All Categories" option
                        echo '<li><a href="shop.php" class="' . ($current_category === 0 ? 'active' : '') . '">All Categories</a></li>';

                        while ($category = mysqli_fetch_assoc($category_result)) {
                            $isActive = $current_category === (int)$category['category_id'] ? 'active' : '';
                            echo '<li><a href="shop.php?category=' . $category['category_id'] . '" class="' . $isActive . '">' .
                                htmlspecialchars($category['name']) . '</a></li>';
                        }
                        ?>
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
                    <select class="form-select" style="width: auto" onchange="window.location.href=this.value">
                        <?php
                        $current_sort = isset($_GET['sort']) ? $_GET['sort'] : 'featured';
                        $category_param = $category_id ? "&category=$category_id" : '';

                        $sort_options = [
                            'featured' => 'Sort by: Featured',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low',
                            'newest' => 'Newest First'
                        ];

                        foreach ($sort_options as $value => $label) {
                            $selected = $current_sort === $value ? ' selected' : '';
                            $url = "shop.php?sort=$value$category_param";
                            echo "<option value=\"$url\"$selected>$label</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <?php
                    require_once 'components/product-card.php';

                    // Get category filter from URL
                    $category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;

                    // Get sort parameter
                    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'featured';

                    // Build query based on category filter and sorting
                    $query = "SELECT p.* FROM products p";
                    if ($category_id) {
                        $query .= " WHERE p.category_id = $category_id";
                    }

                    // Add sorting
                    switch ($sort) {
                        case 'price_low':
                            $query .= " ORDER BY p.price ASC";
                            break;
                        case 'price_high':
                            $query .= " ORDER BY p.price DESC";
                            break;
                        case 'newest':
                            $query .= " ORDER BY p.created_at DESC";
                            break;
                        default: // featured or invalid sort
                            $query .= " ORDER BY RAND()";
                            break;
                    }

                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        echo "Products Query Error: " . mysqli_error($conn);
                        echo "<br>Query was: " . $query;
                    }

                    // Display products
                    $delay = 0;
                    while ($product = mysqli_fetch_assoc($result)) {
                        renderProductCard($product, $delay);
                        $delay += 100;
                    }

                    // Show message if no products found
                    if (mysqli_num_rows($result) == 0) {
                        echo '<div class="col-12 text-center"><p>No products found in this category.</p></div>';
                    }
                    ?>
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