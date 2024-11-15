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

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'LTH';
$color = isset($_GET['color']) ? $_GET['color'] : 'all';

// Build the query based on filters
$sql = "SELECT * FROM Product WHERE 1=1 AND Type = 'bottom'";

if ($color !== 'all') {
  $sql .= " AND Color='$color'";
}

switch ($sort) {
  case 'LTH':
    $sql .= " ORDER BY Price ASC";
    break;
  case 'HTL':
    $sql .= " ORDER BY Price DESC";
    break;
  case 'OLDEST':
    $sql .= " ORDER BY Prodid ASC";
    break;
  case 'NEWEST':
    $sql .= " ORDER BY Prodid DESC";
    break;
  case 'ATZ':
    $sql .= " ORDER BY Name ASC";
    break;
  case 'ZTA':
    $sql .= " ORDER BY Name DESC";
    break;
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="main_wrapper" style="padding: 30px 0px 50px 0px">
    <div class="container">
      <h1 style="text-align: center; margin-bottom: 0px">Filter</h1>
      <form method="GET" action="bottoms.php" class="filter-container">
        <div class="filter-options">
          <label for="sort">Sort By:</label>
          <select id="sort" name="sort">
            <option value="LTH">Price Low To High</option>
            <option value="HTL">Price High To Low</option>
            <option value="OLDEST">Oldest</option>
            <option value="NEWEST">Newest</option>
            <option value="ATZ">A To Z</option>
            <option value="ZTA">Z To A</option>
          </select>
        </div>
        <div class="filter-options">
          <label for="color">Color:</label>
          <select id="color" name="color">
            <option value="all">All</option>
            <option value="red">Red</option>
            <option value="blue">Blue</option>
            <option value="black">Black</option>
            <option value="white">White</option>
            <option value="pink">Pink</option>
          </select>
        </div>
        <button type="submit">Apply Filters</button>
      </form>
      <h1 style="text-align: center; margin-top: 0px">Bottoms</h1>
      <div class="product-grid" id="product-grid">
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<form class="product-item" action="./productdetails.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $row['Prodid'] . '">';
            $opacity = $row['qty'] == 0 ? '0.25' : '1.0';
            echo '<img src="' . $row['image_path'] . '" alt="' . htmlspecialchars($row['Name']) . '" onclick="this.parentNode.submit();" style="cursor: pointer; opacity: ' . $opacity . ';" />';
            echo '<div class="product-labels">';
            if ($row['qty'] == 0) {
              echo '<span class="product-label soldout">Sold Out!</span>';
            }
            if ($row['isNew']) {
              echo '<span class="product-label new">New</span>';
            }
            if ($row['Discount'] > 0) {
              echo '<span class="product-label discount">' . $row['Discount'] . '%</span>';
            }
            echo '</div>';
            echo '<h3 style="text-transform: uppercase;">' . htmlspecialchars($row['Name']) . '</h3>';
            if ($row['Discount'] > 0) {
              $discountedPrice = $row['Price'] * (1 - $row['Discount'] / 100);
              echo '<p><span style="text-decoration: line-through; color: #A9A9A9; padding-right: 10px;">$' . number_format($row['Price'], 2) . '</span> $' . number_format($discountedPrice, 2) . '</p>';
            } else {
              echo '<p>$' . number_format($row['Price'], 2) . '</p>';
            }
            echo '</form>';
          }
        } else {
          echo '<p>No products found.</p>';
        }
        ?>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>