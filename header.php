<!DOCTYPE html>
<html lang="en">

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
                        <li><a href="./cart.php">Cart</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
</body>

</html>