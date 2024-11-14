<?php

session_start();
// Redirect to unauthorize page if not an admin/or not log in 
if (!isset($_SESSION['islogin']) || (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] === 0)) {
    header('Location: unauthorize.php');
    exit();
}

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $color = $_POST['color'];
    $description = $_POST['description'];
    $qty = $_POST['qty'];
    $isnew = $_POST['isnew'];
    $discount = $_POST['discount'];

    if ($id === null) {
        echo "No product found with ID.";
        exit();
    }

    // Update product details in database
    $sql = "UPDATE Product SET Name='$name', Price='$price', Type='$type', Color='$color', Description='$description', qty='$qty', Discount='$discount', isNew='$isnew' WHERE Prodid='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Product details updated in database.<br>";
        header("Location: viewproduct.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br>";
    }
}

mysqli_close($conn);
?>
