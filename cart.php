<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <script type="text/javascript" src="./js/cart.js"></script>
  <style>
    .cart-items {
      display: flex;
      flex-direction: column;
    }

    .cart-item, #cart-item-heading {
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

    .cart-btn{
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
      <div id="cart-items">
        <!-- Cart items will be dynamically added here -->
      </div>
      <h3 style="text-align: right; margin: 20px 350px;">SubTotal: <span id="total-price">$0</span></h3>
      <div class="button-container">
        <form action="./products.php">
          <button class="cart-btn" type="submit">Continue shopping</button>
        </form>
        <form action="./checkout.php">
          <button class="cart-btn" type="submit">Checkout</button>
        </form>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>