<?php

session_start();
// Redirect to unauthorize page if not an admin/or not log in 
if (!isset($_SESSION['islogin']) || (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] === 0)) {
    header('Location: unauthorize.php');
    exit();
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
            <h1 style="margin: 0px 0px 20px 0px;text-align: center;">Create Product</h1>
            <form action="./handlecreateproduct.php" method="POST" id="productForm" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="">Select type</option>
                    <option value="top">Top</option>
                    <option value="bottom">Bottom</option>
                    <option value="dress">Dress</option>
                </select>

                <label for="color">Color</label>
                <select id="color" name="color" required>
                    <option value="">Select color</option>
                    <option value="red">Red</option>
                    <option value="blue">Blue</option>
                    <option value="black">Black</option>
                    <option value="white">White</option>
                    <option value="pink">Pink</option>
                </select>

                <label for="qty">Quantity</label>
                <input type="number" id="qty" name="qty" required>

                <label for="type">IsNew</label>
                <select id="type" name="isnew" required>
                    <option value="">Select New</option>
                    <option value=1>Yes</option>
                    <option value=0>No</option>
                </select>

                <label for="discount">Discount</label>
                <input type="number" id="discount" name="discount" step="0.01" required>

                <label for="productImage">Product Image</label>
                <input style="border-color: white;background-color: white; padding: 5px;" type="file" id="productImage" name="productImage" accept="image/*" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>

                <button type="submit">Submit</button>
            </form>
            <form method="POST" action="./viewproduct.php" id="backform">
                <button class=back-btn type="submit">Back to Product List</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>