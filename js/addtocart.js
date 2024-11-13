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
  const discountInput = document.getElementById("discount");
  const nameInput = document.getElementById("name");
  const idInput = document.getElementById("id");
  const priceInput = document.getElementById("price");
  const dispriceInput = document.getElementById("disprice");
  const colorInput = document.getElementById("color");
  const sizeInput = document.getElementById("size");
  const qtyInput = document.getElementById("qty");
  const maxqtyInput = document.getElementById("maxqty");

  const imgsrc = imgsrcInput.textContent.trim();
  const discount = parseFloat(discountInput.textContent.trim());
  const name = nameInput.textContent.trim();
  const id = idInput.textContent.trim();
  const price = parseFloat(priceInput.textContent.trim().replace("$", ""));
  const disprice = parseFloat(dispriceInput.textContent.trim().replace("$", ""));
  const color = colorInput.textContent;
  const size = sizeInput.value;
  const qty = parseInt(qtyInput.value);
  const maxqty = parseInt(maxqtyInput.textContent);
  
  if (isNaN(qty)) {
    alert('Please enter a valid quantity.');
    return;
  }

  if (!color || !size || qty <= 0 || qty > 10) {
    alert('Please select a color, size, and quantity between 1 and 5.');
    return;
  }

  const product = {
    cid: generateUniqueId(),
    img : imgsrc,
    discount : discount,
    name: name,
    id : id,
    price: price, 
    disprice: disprice,
    color: color,
    size: size,
    qty: qty,
    maxqty: maxqty
  };

  cart.push(product);
  sessionStorage.setItem('cart', JSON.stringify(cart));

  window.location.href = 'cart.php';
}