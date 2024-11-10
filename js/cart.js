// Function to update the cart UI
function updateCart() {
  const cartItemsElement = document.getElementById("cart-items");
  cartItemsElement.innerHTML = "";

  let totalPrice = 0;

  // Retrieve the cart data from sessionStorage
  const cart = JSON.parse(sessionStorage.getItem("cart")) || [];

  cart.forEach((product) => {
    const cartItemElement = document.createElement("div");
    cartItemElement.classList.add("cart-item");
    cartItemElement.innerHTML = `
      <img src=${product.img} alt=${product.name}/>
      <div class="cart-item-details-container">
        <p class="cart-item-details-p" style="width: 200px;">${product.name}</p>
        <p class="cart-item-details-p"><b>Size :</b> <span style="text-transform: uppercase;">${product.size}</span></p>
        <p class="cart-item-details-p"><b>Color :</b> <span style="text-transform: uppercase;">${product.color}</span></p>
      </div>
      <p>$${product.price}</p>
      <div class="quantity-controls">
        <button onclick="changeQuantity(${product.cid}, -1)">-</button>
        <p class="cart-item-details-p">${product.qty}</p>
        <button onclick="changeQuantity(${product.cid}, 1)">+</button>
      </div>
      <p>Total: $${product.price * product.qty}</p>
      <button onclick="removeFromCart(${product.cid})">Remove</button>
    `;
    cartItemsElement.appendChild(cartItemElement);

    totalPrice += product.price * product.qty;
  });

  document.getElementById("total-price").textContent = `$${totalPrice}`;
}

// Function to change the quantity of a product
function changeQuantity(productId, change) {
  // Retrieve the cart data from sessionStorage
  let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

  // Find the product and update its quantity
  cart = cart.map((product) => {
    if (product.cid === productId) {
      product.qty = Math.max(1, Math.min(5, product.qty + change));
    }
    return product;
  });

  // Update the cart data in sessionStorage
  sessionStorage.setItem("cart", JSON.stringify(cart));

  // Update the cart UI
  updateCart();
}

// Function to remove a product from the cart
function removeFromCart(productId) {
  // Retrieve the cart data from sessionStorage
  let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

  // Filter out the product with the given productId
  cart = cart.filter((product) => product.cid !== productId);

  // Update the cart data in sessionStorage
  sessionStorage.setItem("cart", JSON.stringify(cart));

  // Update the cart UI
  updateCart();
}

// Initial cart update
window.addEventListener("load", updateCart);

