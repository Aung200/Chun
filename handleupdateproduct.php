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
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $color = $_POST['color'];
    $description = $_POST['description'];
    $qty = $_POST['qty'];
    $isnew = $_POST['isnew'];
    $discount = $_POST['discount'];
    $oldImage = $_POST['oldImage'];
    $productImage = $_FILES['productImage']['name'];
    $targetDir = "uploads/";

    if ($id === null) {
        echo "No product found with ID.";
        exit();
    }

    // Check if the uploads directory exists, if not create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Update product details in database
    $sql = "UPDATE Product SET Name='$name', Price='$price', Type='$type', Color='$color', Description='$description', qty='$qty', Discount='$discount', isNew='$isnew' WHERE Prodid='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Product details updated in database.<br>";

        // If a product image is uploaded
        if (!empty($productImage)) {
            // Delete the old product image from the uploads folder
            if (!empty($oldImage) && file_exists($oldImage)) {
                unlink($oldImage);
            }

            $targetFile = $targetDir . basename($productImage);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES['productImage']['tmp_name']);
            if ($check !== false) {
                // Check if file already exists and generate a unique file name if it does
                $fileBaseName = pathinfo($targetFile, PATHINFO_FILENAME);
                $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
                $i = 1;
                while (file_exists($targetFile)) {
                    $targetFile = $targetDir . $fileBaseName . '_' . $i . '.' . $fileExtension;
                    $i++;
                }

                // Check file size
                if ($_FILES['productImage']['size'] > 2000000) { // Increase limit to 2,000,000 bytes (approximately 2 MB)
                    echo "Sorry, your file is too large.<br>";
                } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                } else {
                    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
                        echo "File uploaded successfully to $targetFile.<br>";
                        // Update the product's image path in the database
                        $sqlUpdateImage = "UPDATE Product SET image_path='$targetFile' WHERE Prodid='$id'";
                        if (mysqli_query($conn, $sqlUpdateImage)) {
                            echo "The file " . htmlspecialchars(basename($productImage)) . " has been uploaded and product image updated.<br>";
                        } else {
                            echo "Error: " . $sqlUpdateImage . "<br>" . mysqli_error($conn) . "<br>";
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.<br>";
                    }
                }
            } else {
                echo "File is not an image.<br>";
            }
        }

        header("Location: viewproduct.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br>";
    }
}

mysqli_close($conn);
?>
