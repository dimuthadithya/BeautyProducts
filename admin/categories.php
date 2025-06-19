<?php
require_once('../config/db_conn.php');
session_start();

// Delete Category
if (isset($_POST['delete_category'])) {
  $id = mysqli_real_escape_string($conn, $_POST['category_id']);

  // Check if there are any products in this category
  $check_query = "SELECT COUNT(*) as count FROM products WHERE category_id = $id";
  $result = mysqli_query($conn, $check_query);
  $row = mysqli_fetch_assoc($result);

  if ($row['count'] > 0) {
    $_SESSION['message'] = "Cannot delete category: There are products associated with this category!";
    $_SESSION['msg_type'] = "danger";
  } else {
    $query = "DELETE FROM categories WHERE category_id = $id";
    if (mysqli_query($conn, $query)) {
      $_SESSION['message'] = "Category deleted successfully!";
      $_SESSION['msg_type'] = "success";
    } else {
      $_SESSION['message'] = "Error deleting category!";
      $_SESSION['msg_type'] = "danger";
    }
  }
  header("Location: categories.php");
  exit();
}

// Add Category
if (isset($_POST['add_category'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);

  $query = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
  if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Category added successfully!";
    $_SESSION['msg_type'] = "success";
  } else {
    $_SESSION['message'] = "Error adding category!";
    $_SESSION['msg_type'] = "danger";
  }
  header("Location: categories.php");
  exit();
}

// Update Category
if (isset($_POST['update_category'])) {
  $id = mysqli_real_escape_string($conn, $_POST['category_id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);

  $query = "UPDATE categories SET name='$name', description='$description' WHERE category_id=$id";
  if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Category updated successfully!";
    $_SESSION['msg_type'] = "success";
  } else {
    $_SESSION['message'] = "Error updating category!";
    $_SESSION['msg_type'] = "danger";
  }
  header("Location: categories.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Categories - Beauty Store Admin</title> <?php include('include/head.php'); ?>
  <link rel="stylesheet" href="css/categories.css" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('include/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
      <?php
      $pageTitle = "Category Management";
      include('include/header.php');
      ?>

      <!-- Content Area -->
      <div class="content">
        <!-- Add Category Button -->
        <button class="btn btn-primary mb-4" id="addCategoryBtn">
          <i class="fas fa-plus"></i> Add New Category
        </button>

        <!-- Categories Table -->
        <div class="card">
          <div class="card-body"> <?php if (isset($_SESSION['message'])): ?>
              <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
                <?php
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                    unset($_SESSION['msg_type']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Products Count</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT c.*, COUNT(p.product_id) as product_count 
                                             FROM categories c 
                                             LEFT JOIN products p ON c.category_id = p.category_id 
                                             GROUP BY c.category_id";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)):
                  ?>
                    <tr>
                      <td><?php echo $row['category_id']; ?></td>
                      <td><?php echo htmlspecialchars($row['name']); ?></td>
                      <td><?php echo htmlspecialchars($row['description']); ?></td>
                      <td><?php echo $row['product_count']; ?></td>
                      <td>
                        <button class="btn btn-info btn-sm edit-category"
                          data-id="<?php echo $row['category_id']; ?>"
                          data-name="<?php echo htmlspecialchars($row['name']); ?>"
                          data-description="<?php echo htmlspecialchars($row['description']); ?>">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-category"
                          data-id="<?php echo $row['category_id']; ?>">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- Add/Edit Category Modal -->
    <div class="modal" id="categoryModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="modalTitle">Add New Category</h3>
          <button class="close-modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
          <form id="categoryForm" method="POST">
            <input type="hidden" name="category_id" id="category_id">
            <div class="mb-3">
              <label for="name" class="form-label">Category Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-modal">Cancel</button>
              <button type="submit" class="btn btn-primary" id="saveCategory" name="add_category">Save Category</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Delete Category</h3>
          <button class="close-modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this category?</p>
          <form method="POST">
            <input type="hidden" name="category_id" id="delete_category_id">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-modal">Cancel</button>
              <button type="submit" name="delete_category" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-body">
    <form id="categoryForm">
      <div class="form-group">
        <label for="categoryName">Category Name</label>
        <input type="text" id="categoryName" name="name" required />
      </div>
      <div class="form-group">
        <label for="categoryDescription">Description</label>
        <textarea id="categoryDescription" name="description" rows="3"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel">Cancel</button>
        <button type="submit" class="btn-save">Save Category</button>
      </div>
    </form>
  </div>
  </div>
  </div>

  <!-- Scripts -->
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sidebar toggle
      const sidebarToggle = document.getElementById('sidebarToggle');
      const wrapper = document.querySelector('.wrapper');

      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
          wrapper.classList.toggle('sidebar-collapsed');
        });
      }

      // Modal functionality
      const categoryModal = document.getElementById('categoryModal');
      const deleteModal = document.getElementById('deleteModal');
      const addCategoryBtn = document.getElementById('addCategoryBtn');
      const closeButtons = document.querySelectorAll('.close-modal');
      const categoryForm = document.getElementById('categoryForm');

      // Add new category
      if (addCategoryBtn) {
        addCategoryBtn.addEventListener('click', function() {
          document.getElementById('modalTitle').textContent = 'Add New Category';
          document.getElementById('category_id').value = '';
          categoryForm.reset();
          categoryForm.querySelector('button[type="submit"]').name = 'add_category';
          categoryModal.style.display = 'block';
        });
      }

      // Edit category
      document.querySelectorAll('.edit-category').forEach(button => {
        button.addEventListener('click', function() {
          const id = this.dataset.id;
          const name = this.dataset.name;
          const description = this.dataset.description;

          document.getElementById('modalTitle').textContent = 'Edit Category';
          document.getElementById('category_id').value = id;
          document.getElementById('name').value = name;
          document.getElementById('description').value = description;
          categoryForm.querySelector('button[type="submit"]').name = 'update_category';
          categoryModal.style.display = 'block';
        });
      });

      // Delete category
      document.querySelectorAll('.delete-category').forEach(button => {
        button.addEventListener('click', function() {
          const id = this.dataset.id;
          document.getElementById('delete_category_id').value = id;
          deleteModal.style.display = 'block';
        });
      });

      // Close modals
      closeButtons.forEach(button => {
        button.addEventListener('click', function() {
          categoryModal.style.display = 'none';
          deleteModal.style.display = 'none';
        });
      });

      // Close on outside click
      window.onclick = function(event) {
        if (event.target == categoryModal) categoryModal.style.display = 'none';
        if (event.target == deleteModal) deleteModal.style.display = 'none';
      };
    });
  </script>
</body>

</html>