<?php
session_start();

// Store the current page in session for later redirection
$_SESSION['redirect_after_login'] = 'checkout.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['islogin'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vanwalk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userid = $_SESSION['userid'];

$sql = "SELECT Username, Email FROM User WHERE Userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userid);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

$conn->close();

// Retrieve the cart data from the session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate totals
$subtotal = 0;
$totalDiscount = 0;
foreach ($cart as $item) {
    $price = isset($item['disprice']) && $item['disprice'] > 0 ? $item['disprice'] : $item['price'];
    $subtotal += $price * $item['qty'];
    $totalDiscount += ($item['price'] - $price) * $item['qty'];
}
$shippingFee = 5.00;
$totalPayment = $subtotal + $shippingFee;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vanwalk</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
    <style>
        .checkout {
            width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .row {
            display: flex;
            flex-direction: row;
        }

        .user-form {
            flex: 0.5;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: fit-content;
            max-height: 400px;
        }

        .product-info {
            flex: 1;
            padding: 0px 50px 20px 50px;
            overflow: auto;
            overflow-x: hidden;
        }

        .productinfo-h2 {
            position: sticky;
            top: 0;
            z-index: 1;
            padding: 20px 0px 20px 0px;
            margin: 0px;
            background-color: #f6eacb;
        }

        .user-form input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 15px;
            width: 400px;
        }

        label {
            margin-bottom: 10px;
        }

        .product-infodetails-wrap {
            display: flex;
            flex-direction: row;
            height: 130px;
            align-items: center;
            justify-content: space-between;
        }

        .product-infodetails-wrap img {
            transform: scale(0.8);
        }

        .details-text-wrap {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 20px;
        }

        .details-text-wrap p {
            margin: 0px 0px 5px 0px;
        }

        .price-total-wrap {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            margin-left: auto;
        }

        .price-wrap {
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            margin: 30px 100px 0px 20px;
        }

        .subtotal,
        .total,
        .shipping,
        .discountp {
            margin: 0px 0px 10px auto;
        }

        #payment-method {
            width: 250px;
            height: 45px;
            padding: 8px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Amaranth', sans-serif;
            background-color: #d1e9f6;
            font-size: 20px;
        }

        .payment-wrap {
            flex-direction: column;
            margin: 30px 100px 0px 20px;
        }

        .button-wrap {
            justify-content: center;
            margin: 20px 0px;
        }

        .back-button {
            padding: 10px 10px;
            border: none;
            background-color: #d1e9f6;
            font-weight: bold;
            font-size: 18px;
            color: black;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #789DBC;
            color: white;
        }

        .discount-price {
            margin-right: 55px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="main_wrapper" style="padding: 80px 0px">
        <div class="container checkout">
            <h1 style="text-align: center; margin-bottom: 50px;">Checkout</h1>
            <form action="./handlecheckout.php" method="post" id="checkout-form">
                <div class="row">
                    <div class="user-form">
                        <h2 style="padding: 0px 0px 30px 0px; margin: 0px;">User Details</h2>
                        <span id="userid" hidden><?php echo $userid; ?></span>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $username; ?>" required>

                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>

                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="user-form product-info">
                        <h2 class="productinfo-h2">Product Information</h2>
                        <?php if (empty($cart)): ?>
                            <p>Your cart is empty.</p>
                        <?php else: ?>
                            <?php foreach ($cart as $item): ?>
                                <div class="product-infodetails-wrap">
                                    <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="100" />
                                    <div class="details-text-wrap">
                                        <p><?php echo htmlspecialchars($item['name']); ?></p>
                                        <p><b>Size :</b> <span style="text-transform: uppercase;"><?php echo htmlspecialchars($item['size']); ?></span></p>
                                        <p><b>Color :</b> <span style="text-transform: uppercase;"><?php echo htmlspecialchars($item['color']); ?></span></p>
                                        <p><b>Quantity :</b> <?php echo $item['qty']; ?></p>
                                    </div>
                                    <div class="price-total-wrap">
                                        <p style="text-decoration: line-through; color: #a9a9a9;">$<?php echo number_format($item['price'], 2); ?></p>
                                        <p style="margin-left: 15px;">$<?php echo number_format($item['disprice'], 2); ?></p>
                                        <p style="margin-left: 25px;margin-right: 25px;">Total: $<?php echo number_format($price * $item['qty'], 2); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row price-wrap">
                    <div style="display: flex; width: 100%; justify-content: space-between; margin: 0">
                        <h3 class="discountp">Discount :</h3>
                        <h3 class="discountp" id="discountp">-$<?php echo number_format($totalDiscount, 2); ?></h3>
                    </div>
                    <div style="display: flex; width: 100%; justify-content: space-between; margin: 0">
                        <h3 class="subtotal">Subtotal :</h3>
                        <h3 class="subtotal" id="subtotal">$<?php echo number_format($subtotal, 2); ?></h3>
                    </div>
                    <div style="display: flex; width: 100%; justify-content: space-between; margin: 0">
                        <h3 class="shipping">Shipping Fee :</h3>
                        <h3 class="shipping" id="shipping">$<?php echo number_format($shippingFee, 2); ?></h3>
                    </div>
                    <div style="display: flex; width: 100%; justify-content: space-between; margin: 0">
                        <h3 class="total">Total Payment :</h3>
                        <h3 class="total" id="total">$<?php echo number_format($totalPayment, 2); ?></h3>
                    </div>
                </div>
                <div class="row payment-wrap">
                    <div style="display: flex; width: 100%; justify-content: space-between; margin: 0px; align-items: center;">
                        <h3 style="margin-left: auto; margin-right: 20px;">Choose Payment Method :</h3>
                        <select id="payment-method" name="payment-method" required>
                            <option value="credit-card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank-transfer">Bank Transfer</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                </div>
                <div class="row button-wrap">
                    <a class="back-button" style="margin-right: 100px; background-color: #eecad5" href="cart.php">Back to Cart</a>
                    <button class="back-button" type="submit">Complete Order</button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>