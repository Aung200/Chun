<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Retrieve the cart data from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Initialize total price
$totalPrice = 0;

// Handle form submissions for updating quantities and removing items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_qty'])) {
    $cid = $_POST['cid'];
    $change = intval($_POST['change']);
    foreach ($cart as &$product) {
      if ($product['cid'] == $cid) {
        $product['qty'] = max(1, min($product['maxqty'], $product['qty'] + $change));
        break;
      }
    }
    unset($product); // Break the reference with the last element
    $_SESSION['cart'] = $cart;
  } elseif (isset($_POST['remove_item'])) {
    $cid = $_POST['cid'];
    $cart = array_filter($cart, function ($product) use ($cid) {
      return $product['cid'] != $cid;
    });
    $_SESSION['cart'] = array_values($cart); // Re-index the array
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <style>
    .cart-items {
      display: flex;
      flex-direction: column;
    }

    .cart-item,
    #cart-item-heading {
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
      margin-bottom: 20px;
    }

    .cart-item img {
      width: 100px;
      height: auto;
    }

    .cart-item-details-container {
      display: flex;
      flex-direction: column;
    }

    .cart-item-details-p {
      margin: 0px;
    }

    .quantity-controls {
      display: flex;
      align-items: center;
    }

    .quantity-controls p {
      margin: 0px 10px;
    }

    .button-container {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      margin: 50px 110px 50px 110px;
    }

    .cart-btn {
      padding: 12px;
      font-weight: bold;
      font-size: 15px;
      background-color: #eecad5;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="main_wrapper" style="padding: 80px 0px">
    <div class="container">
      <h1 style="text-align: center; margin-bottom: 50px;">Shopping Cart</h1>
      <div id="cart-item-heading">
        <p style="width: 430px;">Product</p>
        <p style="width: 90px;">Price</p>
        <p style="width: 60px;">Quantity</p>
        <p>Subtotal</p>
        <p>Action</p>
      </div>
      <div id="cart-items" class="cart-items">
        <?php if (empty($cart)): ?>
          <p style="text-align: center;">Your cart is empty.</p>
        <?php else: ?>
          <?php
          foreach ($cart as $product):
            $price = isset($product['disprice']) && $product['disprice'] > 0 ? $product['disprice'] : $product['price'];
            $subtotal = $price * $product['qty'];
            $totalPrice += $subtotal;
          ?>
            <div class="cart-item">
              <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
              <div class="cart-item-details-container">
                <p class="cart-item-details-p" style="width: 200px;"><?php echo htmlspecialchars($product['name']); ?></p>
                <p class="cart-item-details-p"><b>Size :</b> <span style="text-transform: uppercase;"><?php echo htmlspecialchars($product['size']); ?></span></p>
                <p class="cart-item-details-p"><b>Color :</b> <span style="text-transform: uppercase;"><?php echo htmlspecialchars($product['color']); ?></span></p>
              </div>
              <p>$<?php echo number_format($price, 2); ?></p>
              <div class="quantity-controls">
                <form method="post" action="cart.php" style="display: inline;">
                  <input type="hidden" name="cid" value="<?php echo $product['cid']; ?>">
                  <input type="hidden" name="change" value="-1">
                  <button type="submit" name="update_qty" <?php echo $product['qty'] == 1 ? 'disabled' : ''; ?>>-</button>
                </form>
                <p class="cart-item-details-p"><?php echo $product['qty']; ?></p>
                <form method="post" action="cart.php" style="display: inline;">
                  <input type="hidden" name="cid" value="<?php echo $product['cid']; ?>">
                  <input type="hidden" name="change" value="1">
                  <button type="submit" name="update_qty" <?php echo $product['qty'] >= min(10, $product['maxqty']) ? 'disabled' : ''; ?>>+</button>
                </form>
              </div>
              <p>Total: $<?php echo number_format($subtotal, 2); ?></p>
              <form method="post" action="cart.php">
                <input type="hidden" name="cid" value="<?php echo $product['cid']; ?>">
                <input type="hidden" name="remove_item" value="1">
                <button type="submit">Remove</button>
              </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <h3 style="text-align: right; margin: 20px 350px;">SubTotal: <span id="total-price">$<?php echo number_format($totalPrice, 2); ?></span></h3>
      <div class="button-container">
        <form action="./products.php">
          <button class="cart-btn" type="submit">Continue shopping</button>
        </form>
        <form action="./checkout.php">
          <button class="cart-btn" type="submit" <?php echo empty($cart) ? 'disabled' : ''; ?>>Checkout</button>
        </form>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>