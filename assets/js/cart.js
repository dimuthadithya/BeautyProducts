function addToCart(productId) {
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
        // This is where you'll add the actual cart functionality
        console.log('Adding product to cart:', productId);
        // Add your cart logic here
      }
    })
    .catch((error) => {
      console.error('Error:', error);
    });
}
