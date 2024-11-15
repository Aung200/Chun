<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['islogin']) && $_SESSION['islogin'] === true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Default';
$is_admin = isset($_SESSION['isadmin']) ? $_SESSION['isadmin'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vanwalk</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
</head>

<body>
    <header class="sticky-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="./index.php">
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
                            <form class="search-form" action="search.php" method="post">
                                <input type="text" placeholder="Search" name="search" />
                                <button type="submit">Go</button>
                            </form>
                        </li>
                        <?php if ($is_logged_in): ?>
                            <li class="dropdown" id="userDD">
                                <span id="usernameDisplay" style="text-transform: uppercase;"><?php echo htmlspecialchars($username); ?></span>
                                <ul class="dropdown-content">
                                    <?php if ($is_admin === 1): ?><li><a href="./viewproduct.php">View Store</a></li><?php endif; ?>
                                    <li><a href="./logout.php">Log Out</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="./login.php">Login</a></li>
                        <?php endif; ?>
                        <li><a href="./cart.php">Cart</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
</body>

</html>