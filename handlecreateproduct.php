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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Function to generate a unique 3-digit ID
    function generateUniqueId($conn, $tableName, $columnName)
    {
        do {
            $id = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $result = mysqli_query($conn, "SELECT * FROM $tableName WHERE $columnName = '$id'");
        } while (mysqli_num_rows($result) > 0);
        return $id;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
            $gid = generateUniqueId($conn, 'Product', 'Prodid');
            // Insert product details into database
            $sql = "INSERT INTO Product (Prodid, Name, Price, Type, Color, Description, qty, isSale, Discount, isNew, created_datetime, image_path) VALUES ('$gid', '$name', '$price', '$type', '$color', '$description', '$qty', '$issale', '$discount', '$isnew', NOW(), '$targetFile')";
            if (mysqli_query($conn, $sql)) {
                echo "The file " . htmlspecialchars(basename($productImage)) . " has been uploaded and product added to database.";
                header("Location: createproduct.php");
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