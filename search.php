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

$search = isset($_POST['search']) ? $_POST['search'] : (isset($_GET['search']) ? $_GET['search'] : '');
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'LTH';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$color = isset($_GET['color']) ? $_GET['color'] : 'all';

// Build the query based on search and filters
$sql = "SELECT * FROM Product WHERE Name LIKE '%$search%'";

if ($category !== 'all') {
  $sql .= " AND Type='$category'";
}

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

// Check if the request is an AJAX request
if (isset($_GET['ajax'])) {
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
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sortSelect = document.getElementById('sort');
      const categorySelect = document.getElementById('category');
      const colorSelect = document.getElementById('color');

      function fetchFilteredProducts() {
        const sort = sortSelect.value;
        const category = categorySelect.value;
        const color = colorSelect.value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `products.php?ajax=1&search=<?php echo $search; ?>&sort=${sort}&category=${category}&color=${color}`, true);
        xhr.onload = function() {
          if (this.status === 200) {
            document.getElementById('product-grid').innerHTML = this.responseText;
          }
        };
        xhr.send();
      }

      sortSelect.addEventListener('change', fetchFilteredProducts);
      categorySelect.addEventListener('change', fetchFilteredProducts);
      colorSelect.addEventListener('change', fetchFilteredProducts);
    });
  </script>
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
  <div class="main_wrapper" style="padding: 30px 0px 50px 0px">
    <div class="container">
      <h1 style="text-align: center; margin-bottom: 0px">Filter</h1>
      <div class="filter-container">
        <div class="filter-options">
          <label for="sort">Sort By:</label>
          <select id="sort">
            <option value="LTH">Price Low To High</option>
            <option value="HTL">Price High To Low</option>
            <option value="OLDEST">Oldest</option>
            <option value="NEWEST">Newest</option>
            <option value="ATZ">A To Z</option>
            <option value="ZTA">Z To A</option>
          </select>
        </div>
        <div class="filter-options">
          <label for="category">Category:</label>
          <select id="category">
            <option value="all">All</option>
            <option value="top">Tops</option>
            <option value="bottom">Bottoms</option>
            <option value="dress">Dresses</option>
          </select>
        </div>
        <div class="filter-options">
          <label for="color">Color:</label>
          <select id="color">
            <option value="all">All</option>
            <option value="red">Red</option>
            <option value="blue">Blue</option>
            <option value="black">Black</option>
            <option value="white">White</option>
            <option value="pink">Pink</option>
          </select>
        </div>
      </div>
      <h1 style="text-align: center; margin-top: 0px">Search Product Named : <?php echo $search;?></h1>
      <div class="product-grid" id="product-grid">
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<form class="product-item" action="./productdetails.php" method="post">';
            echo '<input type="hidden" name="id" value="' . $row['Prodid'] . '">';
            echo '<img src="' . $row['image_path'] . '" alt="' . htmlspecialchars($row['Name']) . '" onclick="this.parentNode.submit();" style="cursor: pointer;" />';
            echo '<div class="product-labels">';
            if ($row['qty'] === 0) {
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
        mysqli_close($conn);
        ?>
      </div>
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
      <p
        style="
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