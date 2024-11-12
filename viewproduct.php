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

// Fetch products
$sql = "SELECT * FROM Product";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vanwalk</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            text-align: center;
        }

        td {
            text-transform: uppercase;
        }

        th {
            padding: 10px;
            background-color: #d1e9f6;
        }

        /* tr:nth-of-type(odd) {
            background-color: #F1D3CE;
        } */

        .abutton {
            padding: 8px;
            background-color: #d1e9f6;
            margin-bottom: 20px;
        }

        .edt-btn-group {
            display: flex;
            flex-direction: row;
            width: fit-content;
            align-items: center;
            justify-content: space-evenly;
        }

        .actionform {
            margin: 20px;
        }

        .fabutton {
            padding: 8px;
            background-color: #eecad5;
            border: 1px solid black;
        }

        table td:last-child {

            /* Remove all styling from the last column */

            border: none;

            padding: 0;

            text-align: left;
            /* Or any other styling you want to remove */

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
    <div class="main_wrapper" style="padding: 80px 0px;">
        <div class="container">
            <h1 style="margin: 0px 0px 20px 0px;text-align: center;">Product List</h1>
            <form method="post" action="./createproduct.php" style="text-align: right;">
                <button class="abutton" type="submit"> + Add Product</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price ($)</th>
                        <th>Type</th>
                        <th>Color</th>
                        <th>Quantity</th>
                        <th>Is New</th>
                        <th>Discount (%)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><img src="<?php echo $row['image_path']; ?>" alt="Product Image" width="50"></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo "$" . number_format($row['Price'], 2); ?></td>
                                <td><?php echo $row['Type']; ?></td>
                                <td><?php echo $row['Color']; ?></td>
                                <td><?php echo $row['qty']; ?></td>
                                <td><?php echo $row['isNew'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $row['Discount'] . "%"; ?></td>
                                <td style="width: 80px;">
                                    <div class="edt-btn-group">
                                        <form method="post" action="./deleteproduct.php" class="actionform">
                                            <input type="hidden" name="id" value="<?php echo $row['Prodid']; ?>">
                                            <button class="fabutton" type="submit">Delete</button>
                                        </form>
                                        <form method="post" action="./updateproduct.php" class="actionform">
                                            <input type="hidden" name="id" value="<?php echo $row['Prodid']; ?>">
                                            <button class="fabutton" type="submit" style="background-color: #d1e9f6;">Update</button>
                                        </form>

                                        <div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" style="text-align: center;padding: 10px;">No products found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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