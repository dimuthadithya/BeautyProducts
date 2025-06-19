function placeOrder() {
  // Get form data
  const form = document.getElementById('checkoutForm');
  const formData = new FormData(form);

  // Validate form
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  // Disable submit button and show loading state
  const submitButton = document.querySelector('button[onclick="placeOrder()"]');
  const originalText = submitButton.innerHTML;
  submitButton.disabled = true;
  submitButton.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Processing...
    `;

  // Submit order
  fetch('process-order.php', {
    method: 'POST',
    body: formData
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Show success message and redirect to order confirmation
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: data.message,
          confirmButtonText: 'View Order'
        }).then((result) => {
          window.location.href = 'order-details.php?id=' + data.order_id;
        });
      } else {
        // Show error message
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.message,
          confirmButtonText: 'OK'
        });

        // Highlight missing fields if any
        if (data.missing_fields) {
          data.missing_fields.forEach((field) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
              input.classList.add('is-invalid');
            }
          });
        }
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong! Please try again.',
        confirmButtonText: 'OK'
      });
    })
    .finally(() => {
      // Reset button state
      submitButton.disabled = false;
      submitButton.innerHTML = originalText;
    });
}
