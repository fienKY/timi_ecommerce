// Toast notification function
function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.className = 'toast show';
  setTimeout(() => {
    toast.className = 'toast';
  }, 2000);
}

// Add to Cart Functionality for Products Pages
document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const productCard = button.closest(".product-card");
      const productName = productCard.querySelector(".product-title").innerText;
      const priceText = productCard.querySelector(".product-price").innerText;
      const price = parseFloat(priceText.replace("RM", "").trim());

      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      const existingItem = cart.find(item => item.name === productName);

      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        cart.push({ name: productName, price: price, quantity: 1 });
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      showToast(`${productName} has been added to your cart.`);
    });
  });
});