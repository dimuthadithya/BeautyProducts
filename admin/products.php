<?php
require_once('../config/db_conn.php');
session_start();

// Add New Product
if (isset($_POST['add_product'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);

  // Handle image upload
  $image_url = '';
  if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
    $target_dir = "../uploads/products/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image_url = "uploads/products/" . $new_filename;
    }
  }

  $query = "INSERT INTO products (name, category_id, description, price, stock_quantity, image_url) 
              VALUES ('$name', '$category_id', '$description', '$price', '$stock_quantity', '$image_url')";

  if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Product added successfully!";
    $_SESSION['msg_type'] = "success";
  } else {
    $_SESSION['message'] = "Error adding product!";
    $_SESSION['msg_type'] = "danger";
  }
  header("Location: products.php");
  exit();
}

// Delete Product
if (isset($_POST['delete_product'])) {
  $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

  // First check if product is in any order
  $check_orders = "SELECT COUNT(*) as count FROM order_items WHERE product_id = $product_id";
  $result = mysqli_query($conn, $check_orders);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    $_SESSION['message'] = "Cannot delete product: It is part of existing orders!";
    $_SESSION['msg_type'] = "danger";
  } else {
    // Check if product is in any cart
    $check_cart = "SELECT COUNT(*) as count FROM cart WHERE product_id = $product_id";
    $result = mysqli_query($conn, $check_cart);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
      // Remove from all carts first
      mysqli_query($conn, "DELETE FROM cart WHERE product_id = $product_id");
    }

    // Delete the product
    $query = "DELETE FROM products WHERE product_id = $product_id";
    if (mysqli_query($conn, $query)) {
      $_SESSION['message'] = "Product deleted successfully!";
      $_SESSION['msg_type'] = "success";
    } else {
      $_SESSION['message'] = "Error deleting product!";
      $_SESSION['msg_type'] = "danger";
    }
  }
  header("Location: products.php");
  exit();
}

// Update Product
if (isset($_POST['update_product'])) {
  $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);

  // Handle image upload if new image is selected
  $image_url = $_POST['current_image'];
  if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
    $target_dir = "../uploads/products/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image_url = "uploads/products/" . $new_filename;
      // Delete old image if it exists
      if ($_POST['current_image'] && file_exists("../" . $_POST['current_image'])) {
        unlink("../" . $_POST['current_image']);
      }
    }
  }

  $query = "UPDATE products SET 
              name = '$name',
              category_id = '$category_id',
              description = '$description',
              price = '$price',
              stock_quantity = '$stock_quantity',
              image_url = '$image_url'
              WHERE product_id = $product_id";

  if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Product updated successfully!";
    $_SESSION['msg_type'] = "success";
  } else {
    $_SESSION['message'] = "Error updating product!";
    $_SESSION['msg_type'] = "danger";
  }
  header("Location: products.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Products - Beauty Store Admin</title> <?php include('include/head.php'); ?>
  <link rel="stylesheet" href="css/sidebar.css" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="css/products.css" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('include/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
      <?php
      $pageTitle = "Product Management";
      include('include/header.php');
      ?>

      <!-- Content Area -->
      <div class="content">
        <div class="container-fluid">
          <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
              <?php
              echo $_SESSION['message'];
              unset($_SESSION['message']);
              unset($_SESSION['msg_type']);
              ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <!-- Products Table -->
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Product</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT p.*, c.name as category_name 
                                        FROM products p 
                                        LEFT JOIN categories c ON p.category_id = c.category_id 
                                        ORDER BY p.product_id DESC";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)):
                      $stock_status = $row['stock_quantity'] > 0 ?
                        '<span class="badge bg-success">In Stock</span>' :
                        '<span class="badge bg-danger">Out of Stock</span>';
                    ?>
                      <tr>
                        <td><?php echo $row['product_id']; ?></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <img
                              src="<?php echo !empty($row['image_url']) ? '../' . $row['image_url'] : 'https://via.placeholder.com/50'; ?>"
                              alt="<?php echo htmlspecialchars($row['name']); ?>"
                              class="me-2"
                              style="width: 50px; height: 50px; object-fit: cover;" />
                            <div>
                              <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                            </div>
                          </div>
                        </td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td>LKR <?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                        <td><?php echo $stock_status; ?></td>
                        <td>
                          <button
                            class="btn btn-sm btn-primary me-1 edit-product"
                            data-bs-toggle="modal"
                            data-bs-target="#editProductModal"
                            data-id="<?php echo $row['product_id']; ?>"
                            data-name="<?php echo htmlspecialchars($row['name']); ?>"
                            data-category="<?php echo $row['category_id']; ?>"
                            data-description="<?php echo htmlspecialchars($row['description']); ?>"
                            data-price="<?php echo $row['price']; ?>"
                            data-stock="<?php echo $row['stock_quantity']; ?>"
                            data-image="<?php echo $row['image_url']; ?>">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button
                            class="btn btn-sm btn-danger delete-product"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteProductModal"
                            data-id="<?php echo $row['product_id']; ?>"
                            data-name="<?php echo htmlspecialchars($row['name']); ?>">
                            <i class="fas fa-trash"></i>
                          </button>

                        </td>
                      </tr>
                      <!-- More product rows... -->
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="mb-3">
                <label for="add_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="add_name" name="name" required>
              </div>

              <div class="mb-3">
                <label for="add_category" class="form-label">Category</label>
                <select class="form-control" id="add_category" name="category_id" required>
                  <option value="">Select Category</option>
                  <?php
                  $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
                  while ($cat = mysqli_fetch_assoc($categories)) {
                    echo "<option value='" . $cat['category_id'] . "'>" . htmlspecialchars($cat['name']) . "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="add_description" class="form-label">Description</label>
                <textarea class="form-control" id="add_description" name="description" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label for="add_price" class="form-label">Price</label>
                <input type="number" class="form-control" id="add_price" name="price" step="0.01" required>
              </div>

              <div class="mb-3">
                <label for="add_stock" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" id="add_stock" name="stock_quantity" required>
              </div>

              <div class="mb-3">
                <label for="add_image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="add_image" name="image" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="product_id" id="edit_product_id">
              <input type="hidden" name="current_image" id="current_image">

              <div class="mb-3">
                <label for="edit_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="edit_name" name="name" required>
              </div>

              <div class="mb-3">
                <label for="edit_category" class="form-label">Category</label>
                <select class="form-control" id="edit_category" name="category_id" required>
                  <?php
                  $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
                  while ($cat = mysqli_fetch_assoc($categories)) {
                    echo "<option value='" . $cat['category_id'] . "'>" . htmlspecialchars($cat['name']) . "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="edit_description" class="form-label">Description</label>
                <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label for="edit_price" class="form-label">Price</label>
                <input type="number" class="form-control" id="edit_price" name="price" step="0.01" required>
              </div>

              <div class="mb-3">
                <label for="edit_stock" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" id="edit_stock" name="stock_quantity" required>
              </div>

              <div class="mb-3">
                <label for="edit_image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                <div id="current_image_preview" class="mt-2"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this product: <span id="delete_product_name"></span>?</p>
            <p class="text-danger">This action cannot be undone.</p>
            <form action="" method="POST">
              <input type="hidden" name="product_id" id="delete_product_id">
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="delete_product" class="btn btn-danger">Delete Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Edit Product
        const editButtons = document.querySelectorAll('.edit-product');
        editButtons.forEach(button => {
          button.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('editProductModal'));

            // Fill the form with product data
            document.getElementById('edit_product_id').value = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_category').value = this.dataset.category;
            document.getElementById('edit_description').value = this.dataset.description;
            document.getElementById('edit_price').value = this.dataset.price;
            document.getElementById('edit_stock').value = this.dataset.stock;
            document.getElementById('current_image').value = this.dataset.image;

            // Show current image preview
            const imagePreview = document.getElementById('current_image_preview');
            if (this.dataset.image) {
              imagePreview.innerHTML = `<img src="../${this.dataset.image}" alt="Current Image" style="max-width: 100px;">`;
            } else {
              imagePreview.innerHTML = '';
            }

            modal.show();
          });
        });

        // Delete Product
        const deleteButtons = document.querySelectorAll('.delete-product');
        deleteButtons.forEach(button => {
          button.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
            document.getElementById('delete_product_id').value = this.dataset.id;
            document.getElementById('delete_product_name').textContent = this.dataset.name;
            modal.show();
          });
        });
      });

      document.addEventListener('DOMContentLoaded', function() {
        // Add Product Image Preview
        const addImageInput = document.getElementById('add_image');
        if (addImageInput) {
          addImageInput.addEventListener('change', function() {
            const [file] = this.files;
            if (file) {
              const preview = document.createElement('img');
              preview.src = URL.createObjectURL(file);
              preview.style = 'max-width: 100px; margin-top: 10px;';

              const container = this.parentElement;
              const oldPreview = container.querySelector('img');
              if (oldPreview) oldPreview.remove();
              container.appendChild(preview);
            }
          });
        }

        // Form Validation
        const addProductForm = document.querySelector('#addProductModal form');
        if (addProductForm) {
          addProductForm.addEventListener('submit', function(e) {
            const price = parseFloat(document.getElementById('add_price').value);
            const stock = parseInt(document.getElementById('add_stock').value);

            if (price <= 0 || stock < 0) {
              e.preventDefault();
              alert(price <= 0 ? 'Price must be greater than 0' : 'Stock quantity cannot be negative');
            }
          });
        }
      });
    </script>
  </div>
  </div>
</body>

</html>