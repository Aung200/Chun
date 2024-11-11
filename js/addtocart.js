// Initialize cart
let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

// Function to generate a unique ID
function generateUniqueId() {
  return Date.now() + Math.floor(Math.random() * 1000);
}

// Function to add a product to the cart
function addToCart(event) {
  event.preventDefault();

  const imgsrcInput = document.getElementById("imgsrc");
  const nameInput = document.getElementById("name");
  const priceInput = document.getElementById("price");
  const colorInput = document.getElementById("color");
  const sizeInput = document.getElementById("size");
  const qtyInput = document.getElementById("qty");

  const imgsrc = imgsrcInput.textContent.trim();

  console.log(imgsrc)

  const name = nameInput.textContent.trim();
  const price = parseFloat(priceInput.textContent.trim().replace("$", ""));
  const color = colorInput.value;
  const size = sizeInput.value;
  const qty = parseInt(qtyInput.value);
  
  if (isNaN(qty)) {
    alert('Please enter a valid quantity.');
    return;
  }

  if (!color || !size || qty <= 0 || qty > 5) {
    alert('Please select a color, size, and quantity between 1 and 5.');
    return;
  }

  const product = {
    cid: generateUniqueId(),
    img : imgsrc,
    name: name,
    price: price, 
    color: color,
    size: size,
    qty: qty,
  };

  cart.push(product);
  sessionStorage.setItem('cart', JSON.stringify(cart));

  alert('Item added to the cart!');
}