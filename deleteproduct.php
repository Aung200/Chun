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

    if ($id === null) {
        echo "No product found with ID.";
        exit();
    }

    // Get the image path of the product to be deleted
    $sql = "SELECT image_path FROM Product WHERE Prodid='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image_path'];

        // Delete the product from the database
        $sqlDelete = "DELETE FROM Product WHERE Prodid='$id'";
        if (mysqli_query($conn, $sqlDelete)) {
            echo "Product deleted from database.";

            // Delete the image file from the directory
            if (!empty($imagePath) && file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    echo "Image deleted from directory.";
                } else {
                    echo "Error deleting image from directory.";
                }
            } else {
                echo "Image file does not exist.";
            }

            // Redirect to viewproduct.php
            header("Location: viewproduct.php");
            exit();
        } else {
            echo "Error: " . $sqlDelete . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "No product found with the given ID.";
    }
}

mysqli_close($conn);
?>
