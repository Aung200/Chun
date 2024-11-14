<?php
session_start();
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
$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$address = sanitizeInput($_POST['address']);
$phone = sanitizeInput($_POST['phone']);
$payment_method = sanitizeInput($_POST['payment-method']);

// Retrieve the cart items from session storage via JavaScript
$cart_items = json_decode($_POST['cart_items'], true);

$all_successful = true;

foreach ($cart_items as $item) {
    $orderid = generateUniqueId($conn, 'Order', 'orderid');
    $productname = sanitizeInput($item['name']);
    $price = sanitizeInput($item['disprice']) * sanitizeInput($item['qty']);
    $size = sanitizeInput($item['size']);
    $color = sanitizeInput($item['color']);
    $qty = sanitizeInput($item['qty']);
    $image_path = sanitizeInput($item['img']);
    $prodid = sanitizeInput($item['id']);

    // Construct the SQL query for inserting order
    $sql = "INSERT INTO `Order` (orderid, productname, price, size, color, address, phoneno, qty, image_path, payment_method, ordered_datetime, Prodid, userid) 
            VALUES ('$orderid', '$productname', '$price', '$size', '$color', '$address', '$phone', '$qty', '$image_path', '$payment_method', NOW(), '$prodid', '$userid')";

    if ($conn->query($sql) !== TRUE) {
        $all_successful = false;
        echo "Error: " . $sql . "<br>" . $conn->error;
        break;
    }

    // Update the product quantity in the Product table
    $update_qty_sql = "UPDATE `Product` SET qty = qty - $qty WHERE Prodid = '$prodid'";
    if ($conn->query($update_qty_sql) !== TRUE) {
        $all_successful = false;
        echo "Error updating product quantity: " . $conn->error;
        break;
    }
}

$conn->close();

if ($all_successful) {
    // Redirect to a thank you or order confirmation page only if all queries were successful
    header('Location: thankyou.php');
    exit();
} else {
    echo "<script>alert('There was an error processing your order. Please try again.'); window.location.href = 'checkout.php';</script>";
}

function generateUniqueId($conn, $tableName, $columnName) {
    do {
        $id = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $result = mysqli_query($conn, "SELECT * FROM `$tableName` WHERE $columnName = '$id'");
    } while (mysqli_num_rows($result) > 0);
    return $id;
}

function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}
?>
