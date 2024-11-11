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

$product = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Product WHERE Prodid = '$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "No product found with ID: $id";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $color = $_POST['color'];
    $description = $_POST['description'];
    $qty = $_POST['qty'];
    $isnew = $_POST['isnew'];
    $issale = $_POST['issale'];
    $discount = $_POST['discount'];

    $productImage = $_FILES['productImage']['name'];
    $targetDir = "uploads/";

    // Check if the uploads directory exists, if not create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $targetFile = $targetDir . basename($productImage);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['productImage']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists and generate a unique file name if it does
    $fileBaseName = pathinfo($targetFile, PATHINFO_FILENAME);
    $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
    $i = 1;
    while (file_exists($targetFile)) {
        $targetFile = $targetDir . $fileBaseName . '_' . $i . '.' . $fileExtension;
        $i++;
    }

    // Check file size
    if ($_FILES['productImage']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
            // Update product details in database
            $sql = "UPDATE Product SET Name='$name', Price='$price', Type='$type', Color='$color', Description='$description', qty='$qty', isSale='$issale', Discount='$discount', isNew='$isnew', image_path='$targetFile' WHERE Prodid='$id'";
            if (mysqli_query($conn, $sql)) {
                echo "The file " . htmlspecialchars(basename($productImage)) . " has been uploaded and product updated in the database.";
                header("Location: viewproduct.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

mysqli_close($conn);
?>
