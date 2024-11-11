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
                        <li><a href="./newarrivals.html">New Arrivals</a></li>
                        <li><a href="./sales.html">On Sales</a></li>
                        <li class="dropdown">
                            <a href="./products.html">Products</a>
                            <ul class="dropdown-content">
                                <li><a href="./tops.html">Tops</a></li>
                                <li><a href="./bottoms.html">Bottoms</a></li>
                                <li><a href="./dresses.html">Dresses</a></li>
                            </ul>
                        </li>
                        <li>
                            <form class="search-form" action="./search.html" method="post">
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
    <div class="main_wrapper" style="padding: 80px 0px 65px 0px;">
        <div class="container">
            <h1 style="margin: 0px 0px 20px 0px;text-align: center;">Create Product</h1>
            <form action="./handleupdateproduct.php" method="POST" id="productForm" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product['Prodid']; ?>">

                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo $product['Name']; ?>" required>

                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['Price']; ?>" required>

                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="">Select type</option>
                    <option value="top" <?php if ($product['Type'] == 'top') echo 'selected'; ?>>Top</option>
                    <option value="bottom" <?php if ($product['Type'] == 'bottom') echo 'selected'; ?>>Bottom</option>
                    <option value="dress" <?php if ($product['Type'] == 'dress') echo 'selected'; ?>>Dress</option>
                </select>

                <label for="color">Color</label>
                <select id="color" name="color" required>
                    <option value="">Select color</option>
                    <option value="red" <?php if ($product['Color'] == 'red') echo 'selected'; ?>>Red</option>
                    <option value="blue" <?php if ($product['Color'] == 'blue') echo 'selected'; ?>>Blue</option>
                    <option value="black" <?php if ($product['Color'] == 'black') echo 'selected'; ?>>Black</option>
                    <option value="white" <?php if ($product['Color'] == 'white') echo 'selected'; ?>>White</option>
                    <option value="pink" <?php if ($product['Color'] == 'pink') echo 'selected'; ?>>Pink</option>
                </select>

                <label for="qty">Quantity</label>
                <input type="number" id="qty" name="qty" value="<?php echo $product['qty']; ?>" required>

                <label for="isnew">Is New</label>
                <select id="isnew" name="isnew" required>
                    <option value="">Select New</option>
                    <option value="1" <?php if ($product['isNew'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="0" <?php if ($product['isNew'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label for="issale">On Sale</label>
                <select id="issale" name="issale" required>
                    <option value="">Select Sale</option>
                    <option value="1" <?php if ($product['isSale'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="0" <?php if ($product['isSale'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label for="discount">Discount</label>
                <input type="number" id="discount" name="discount" step="0.01" value="<?php echo $product['Discount']; ?>" required>

                <label for="productImage">Product Image</label>
                <img src="<?php echo $product['image_path']; ?>" alt="Product Image" width="100">
                <input style="border-color: white;background-color: white; padding: 5px;" type="file" id="productImage" name="productImage" accept="image/*">

                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo $product['Description']; ?></textarea>

                <button type="submit">Update</button>
            </form>
            <form method="POST" action="./viewproduct.php" id="backform">
                <button class="back-btn" type="submit">Back to Product List</button>
            </form>
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
                            <li><a href="./newarrivals.html">New Arrivals</a></li>
                            <li><a href="./sales">On Sales</a></li>
                            <li><a href="./products.html">Products</a></li>
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
            <p style="
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