function addToCart(productId, quantity = 1) {
  // Make an AJAX call to check login status
  fetch('check-auth.php')
    .then((response) => response.json())
    .then((data) => {
      if (!data.isLoggedIn) {
        // If not logged in, redirect to login page with return URL
        const currentPage = encodeURIComponent(window.location.href);
        window.location.href = `login.php?redirect=${currentPage}`;
      } else {
        // If logged in, proceed with adding to cart
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch('add-to-cart.php', {
          method: 'POST',
          body: formData
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Show success message
              const toast = document.createElement('div');
              toast.className =
                'toast show position-fixed bottom-0 mt-2 end-0 m-3';
              toast.setAttribute('role', 'alert');
              toast.innerHTML = `
              <div class="toast-header bg-success text-white">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
              </div>
              <div class="toast-body">
                ${data.message}
              </div>
            `;
              document.body.appendChild(toast);

              // Update cart count in navbar if it exists
              const cartCount = document.querySelector('.cart-count');
              if (cartCount) {
                cartCount.textContent = data.cart_count;
              }

              // Remove toast after 3 seconds
              setTimeout(() => {
                toast.remove();
              }, 3000);
            } else {
              // Show error message
              alert(data.message);
            }
          })
          .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred while adding the product to cart');
          });
      }
    })
    .catch((error) => {
      console.error('Error:', error);
    });
}

function updateQuantity(productId, action, value = null) {
  let quantity;
  const input = event.target.parentElement.querySelector('input');

  if (action === 'increase') {
    quantity = parseInt(input.value) + 1;
  } else if (action === 'decrease') {
    quantity = parseInt(input.value) - 1;
  } else if (action === 'set') {
    quantity = parseInt(value);
  }

  if (quantity < 1) {
    return;
  }

  const formData = new FormData();
  formData.append('action', 'update');
  formData.append('product_id', productId);
  formData.append('quantity', quantity);

  fetch('update-cart.php', {
    method: 'POST',
    body: formData
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Update quantity input
        input.value = quantity;

        // Update summary values
        updateSummaryValues(data.subtotal, data.shipping, data.tax, data.total);

        // Update cart count in navbar if it exists
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
          cartCount.textContent = data.cart_count;
        }
      } else {
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('An error occurred while updating the cart');
    });
}

function removeFromCart(cartId) {
  if (!confirm('Are you sure you want to remove this item from your cart?')) {
    return;
  }

  const formData = new FormData();
  formData.append('action', 'remove');
  formData.append('cart_id', cartId);

  fetch('update-cart.php', {
    method: 'POST',
    body: formData
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Remove the cart item from DOM
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        cartItem.remove(); // Update summary values
        updateSummaryValues(data.subtotal, data.shipping, data.tax, data.total);

        // Update cart count in navbar if it exists
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
          cartCount.textContent = data.cart_count;
        }

        // If cart is empty, refresh the page to show empty cart message
        if (data.cart_count === 0) {
          location.reload();
        }
      } else {
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('An error occurred while removing the item from cart');
    });
}

// Helper function to format currency
function formatCurrency(amount) {
  return parseFloat(amount).toFixed(2);
}

// Helper function to update summary values
function updateSummaryValues(subtotal, shipping, tax, total) {
  document.querySelector(
    '.summary-item:nth-child(1) span:last-child'
  ).textContent = `LKR ${formatCurrency(subtotal)}`;
  document.querySelector(
    '.summary-item:nth-child(2) span:last-child'
  ).textContent = `LKR ${formatCurrency(shipping)}`;
  document.querySelector(
    '.summary-item:nth-child(3) span:last-child'
  ).textContent = `LKR ${formatCurrency(tax)}`;
  document.querySelector(
    '.summary-item.total span:last-child'
  ).textContent = `LKR ${formatCurrency(total)}`;
}
