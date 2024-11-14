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
    <?php include 'header.php'; ?>
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
                                <td>
                                    <form method="post" action="./updateimage.php">
                                        <input type="hidden" name="id" value="<?php echo $row['Prodid']; ?>">
                                        <button type="submit" style="border: none; background: none; padding: 0;">
                                            <img src="<?php echo $row['image_path']; ?>" alt="Product Image" width="50">
                                        </button>
                                    </form>
                                </td>
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
                                    </div>
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
    <?php include 'footer.php'; ?>
</body>

</html>