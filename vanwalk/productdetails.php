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
    $qty = $row['qty'];
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
  <?php include 'header.php'; ?>
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
              <span id="discount" hidden><?php echo $discount; ?></span>
              <h1 id="name"><?php echo $name; ?></h1>
              <span id="id" hidden><?php echo $prodid; ?></span>
              <p style="font-weight: bold;margin: 0px;">
                <?php if ($discountedPrice): ?>
                  <span style="text-decoration: line-through; color: #A9A9A9; padding-right: 10px;" id="price">$<?php echo $price; ?></span>
                  <span id="disprice">$<?php echo $discountedPrice; ?></span>
                <?php else: ?>
                  <span id="disprice" hidden>$0</span>
                  <span id="price">$<?php echo $price; ?></span>
                <?php endif; ?>
              </p>
              <p style="margin-bottom: 50px;"><?php echo $description; ?></p>
              <label for="color" style="margin-bottom: 18px;">Color: <span id="color" style="text-transform: uppercase;"><?php echo $color; ?></span></label>
              <label for="size" style="margin-bottom: 18px;" id="size" >Size: Free</label>
              <label for="qty">Quantity:</label>
              <label id="maxqty" hidden><?php echo $qty; ?></label>
              <select id="qty">
                <?php if ($qty == 0): ?>
                  <option value="0">0</option>
                <?php else: ?>
                  <?php
                  $maxQty = min($qty, 10); // Maximum 10 or available quantity
                  for ($i = 1; $i <= $maxQty; $i++) {
                    echo "<option value=\"$i\">$i</option>";
                  }
                  ?>
                <?php endif; ?>
              </select>
              <?php if ($qty == 0): ?>
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
  <?php include 'footer.php'; ?>
</body>

</html>