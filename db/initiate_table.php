<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the database exists
$dbExists = mysqli_query($conn, "SHOW DATABASES LIKE 'vanwalk'");
if (mysqli_num_rows($dbExists) == 0) {
    // Database does not exist, create the database
    $sql = "CREATE DATABASE vanwalk";
    if (mysqli_query($conn, $sql)) {
        echo "Database vanwalk created successfully <br>";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    }
}

// Select the vanwalk database
mysqli_select_db($conn, 'vanwalk');

// Function to check and create table
function checkAndCreateTable($conn, $tableName, $createQuery) {
    $tableExists = mysqli_query($conn, "SHOW TABLES LIKE '$tableName'");
    if (mysqli_num_rows($tableExists) == 0) {
        if (mysqli_query($conn, $createQuery)) {
            echo "Table $tableName created successfully <br>";
            return true;
        } else {
            echo "Error creating table $tableName: " . mysqli_error($conn);
            return false;
        }
    } else {
        echo "Table $tableName already exists <br>";
        return false;
    }
}

// Function to generate a unique 3-digit ID
function generateUniqueId($conn, $tableName, $columnName) {
    do {
        $id = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $result = mysqli_query($conn, "SELECT * FROM $tableName WHERE $columnName = '$id'");
    } while (mysqli_num_rows($result) > 0);
    return $id;
}

// Create User table
$userTableQuery = "CREATE TABLE User (
    Userid CHAR(3) NOT NULL PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(30) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    isadmin BOOLEAN NOT NULL
)";
if (checkAndCreateTable($conn, 'User', $userTableQuery)) {
    // Insert admin and user accounts into User table
    $gId = generateUniqueId($conn, 'User', 'Userid');
    $adminInsertQuery = "INSERT INTO User (Userid, Username, Password, Email, isadmin) VALUES 
        ('$gId', 'admin', 'admin1234', 'admin@gmail.com', true)";
    if (mysqli_query($conn, $adminInsertQuery)) {
        echo "Admin and user accounts created successfully <br>";
    } else {
        echo "Error inserting admin and user accounts: " . mysqli_error($conn);
    }
}

// Create Product table
$productTableQuery = "CREATE TABLE Product (
    Prodid CHAR(3) NOT NULL PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Price FLOAT NOT NULL,
    Type VARCHAR(50) NOT NULL,
    Color VARCHAR(50) NOT NULL,
    Description LONGTEXT NOT NULL,
    qty INT(11) NOT NULL,
    Discount FLOAT NOT NULL,
    isNew BOOLEAN NOT NULL,
    created_datetime DATETIME NOT NULL,
    image_path VARCHAR(255) NOT NULL
)";
checkAndCreateTable($conn, 'Product', $productTableQuery);

// Create Order table
$orderTableQuery = "CREATE TABLE `Order` (
    orderid CHAR(3) NOT NULL PRIMARY KEY,
    productname VARCHAR(50) NOT NULL,
    price FLOAT NOT NULL,
    size VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL,
    address VARCHAR(500) NOT NULL,
    phoneno VARCHAR(500) NOT NULL,
    qty INT(11) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    payment_method VARCHAR(255) NOT NULL,
    ordered_datetime DATETIME NOT NULL,
    Prodid CHAR(3),
    userid CHAR(3),
    FOREIGN KEY (Prodid) REFERENCES Product(Prodid),
    FOREIGN KEY (userid) REFERENCES User(Userid)
)";
checkAndCreateTable($conn, 'Order', $orderTableQuery);

mysqli_close($conn);
?>
