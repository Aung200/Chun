<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vanwalk";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the product ID from the POST request
$prodid = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($prodid > 0) {
  // Fetch product details from the database
  $sql = "SELECT * FROM Product WHERE Prodid = $prodid";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Store product details in variables
    $name = htmlspecialchars($row['Name']);
    $imagePath = $row['image_path'];
    $price = number_format($row['Price'], 2);
    $description = htmlspecialchars($row['Description']);
    $color = htmlspecialchars($row['Color']);
    $discount = $row['Discount'];
    $discountedPrice = $discount > 0 ? number_format($row['Price'] * (1 - $discount / 100), 2) : null;
  } else {
    $error = "Product not found.";
  }
} else {
  $error = "Invalid product ID.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <script type="text/javascript" src="./js/addtocart.js"></script>
  <style>
    /* Add your CSS styles here */
    .productdetails-container {
      display: flex;
      flex-direction: row;
      justify-content: center;
    }

    .productdetails-image {
      display: flex;
      flex-direction: column;
      margin-right: 50px;
    }

    .productdetails-image img {
      width: 400px;
      height: auto;
    }

    .product-details {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .add-to-cart-form {
      display: flex;
      flex-direction: column;
    }

    #color,
    #size,
    #qty {
      margin: 10px 0px;
      width: 100px;
      padding: 8px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .cart_btn {
      padding: 8px;
      width: 250px;
      font-weight: bold;
      margin-top: 20px;
    }

    .cart_btn.sold-out {
      cursor: not-allowed;
      background-color: #ccc;
      border: none;
    }

    .cart_btn.sold-out:hover {
      background-color: #ccc;
    }
  </style>
</head>

<body>
  <header class="sticky-header">
    <div class="container">
      <div class="header-content">
        <div class="logo">
          <a href="./index.html">
            <img src="./public/logo.jpeg" alt="Vanwalk Logo" />
          </a>
        </div>
        <nav>
          <ul>
            <li><a href="./newarrivals.php">New Arrivals</a></li>
            <li><a href="./sales.php">On Sales</a></li>
            <li class="dropdown">
              <a href="./products.php">Products</a>
              <ul class="dropdown-content">
                <li><a href="./tops.php">Tops</a></li>
                <li><a href="./bottoms.php">Bottoms</a></li>
                <li><a href="./dresses.php">Dresses</a></li>
              </ul>
            </li>
            <li>
              <form class="search-form" action="./search.php" method="post">
                <input type="text" placeholder="Search" name="search" />
                <button type="submit">Go</button>
              </form>
            </li>
            <li><a href="./login.html">Login</a></li>
            <li><a href="./cart.html">Cart</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
  <div class="main_wrapper" style="padding: 50px 0px 50px 0px">
    <div class="container">
      <div class="productdetails-container">
        <?php if (isset($error)): ?>
          <p><?php echo $error; ?></p>
        <?php else: ?>
          <div class="productdetails-image">
            <img src="<?php echo $imagePath; ?>" alt="<?php echo $name; ?>" />
          </div>
          <div class="product-details">
            <form class="add-to-cart-form" onsubmit="addToCart(event)">
              <span id="imgsrc" hidden><?php echo $imagePath; ?></span>
              <h1 id="name"><?php echo $name; ?></h1>
              <p style="font-weight: bold;margin: 0px;" id="price">
                <?php if ($discountedPrice): ?>
                  <span style="text-decoration: line-through; color: #A9A9A9; padding-right: 10px;">$<?php echo $price; ?></span>
                  <span>$<?php echo $discountedPrice; ?></span>
                <?php else: ?>
                  $<?php echo $price; ?>
                <?php endif; ?>
              </p>
              <p style="margin-bottom: 50px;"><?php echo $description; ?></p>
              <label for="color" style="margin-bottom: 18px;">Color: <?php echo $color; ?></label>
              <label for="size">Size:</label>
              <select id="size">
                <option value="xs">XS</option>
                <option value="s">S</option>
                <option value="m">M</option>
                <option value="l">L</option>
              </select>
              <label for="qty">Quantity:</label>
              <select id="qty">
                <?php if ($row['qty'] == 0): ?>
                  <option value="0">0</option>
                <?php else: ?>
                  <?php
                  $maxQty = min($row['qty'], 10); // Maximum 10 or available quantity
                  for ($i = 1; $i <= $maxQty; $i++) {
                    echo "<option value=\"$i\">$i</option>";
                  }
                  ?>
                <?php endif; ?>
              </select>
              <?php if ($row['qty'] == 0): ?>
                <button class="cart_btn sold-out" type="submit" disabled>Sold Out</button>
              <?php else: ?>
                <button class="cart_btn" type="submit">Add to Cart</button>
              <?php endif; ?>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <footer class="sticky-footer">
    <div class="container">
      <div class="footer-content">
        <div class="contact-info">
          <p><b>About Us</b></p>
          <p>
            Vanwalk offers an online shopping experience for clothing,<br />
            featuring Tops, Bottoms, and Dresses. Users can browse, filter,<br />
            and search for products, add items to a cart, and checkout. <br />
            Registration and login are required for purchases, <br />
            with receipts sent via email.
          </p>
        </div>
        <div class="contact-info">
          <p><b>SiteMaps</b></p>
          <nav>
            <ul>
              <li><a href="./index.html">Home</a></li>
              <li><a href="./newarrivals.php">New Arrivals</a></li>
              <li><a href="./sales.php">On Sales</a></li>
              <li><a href="./products.php">Products</a></li>
            </ul>
          </nav>
        </div>
        <div class="contact-info">
          <p><b>Contact Info</b></p>
          <p>
            <b>Address:</b> 44 Pekin Street #02-01 Far East Square,
            Singapore<br />
            <b>Telephone:</b> +65 62255366<br />
            <b>Email:</b>
            <a href="mailto:vanwalk@gmail.com" style="color: black">vanwalk@gmail.com</a>
          </p>
        </div>
      </div>
      <p
        style="
            text-align: center;
            border-top: 1px solid rgba(0, 0, 0, 0.253);
            padding: 20px 0px 0px 0px;
            margin-bottom: 0px;
          ">
        &copy; 2023 Vanwalk. All rights reserved.
      </p>
    </div>
  </footer>
</body>

</html>