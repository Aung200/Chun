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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM Product WHERE Prodid = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "No product found with ID: $id";
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
        #productForm {
            border: 1px solid #ccc;
            width: 300px;
            margin: 0 auto;
            padding: 30px;
            display: flex;
            flex-direction: column;
            background-color: #eecad5;
            border-radius: 5px;
        }

        #productForm label {
            display: block;
            margin-bottom: 8px;
        }

        #productForm input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        #productForm select {
            padding: 8px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        #description {
            margin-bottom: 10px;
        }

        #productForm button,
        #backform button {
            padding: 8px;
            color: black;
            margin-top: 15px;
            border-radius: 4px;
            cursor: pointer;
            width: fit-content;
        }

        #backform {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #backform button {
            width: fit-content;
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="main_wrapper" style="padding: 80px 0px 65px 0px;">
        <div class="container">
            <h1 style="margin: 0px 0px 20px 0px;text-align: center;">Update Product Image</h1>
            <form action="./handleupdateimage.php" method="POST" id="productForm" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product['Prodid']; ?>">
                <label for="productImage">Old Product Image : </label>
                <?php
                $imageFileName = basename($product['image_path']);
                ?>
                <span style="margin-bottom: 10px;"><?php echo $imageFileName; ?></span>
                <img src="<?php echo $product['image_path']; ?>" alt="Product Image" width="100" style="margin-bottom: 10px;" title="<?php echo $product['image_path']; ?>">

                <input style="border-color: white;background-color: white; padding: 5px;" type="file" id="productImage" name="productImage" accept="image/*" required>
                <input type="hidden" name="oldImage" value="<?php echo $product['image_path']; ?>">

                <button type="submit">Update</button>
            </form>
            <form method="POST" action="./viewproduct.php" id="backform">
                <button class="back-btn" type="submit">Back to Product List</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>