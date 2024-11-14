<?php
session_start();

// Redirect to a different page if already logged in
if (isset($_SESSION['islogin']) && $_SESSION['islogin'] === true) {
  header('Location: products.php');
  exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vanwalk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare and bind
  $stmt = $conn->prepare("SELECT Userid, Password, isadmin FROM User WHERE Username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($userid, $hashed_password, $isadmin);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      // Set session variables
      $_SESSION['userid'] = $userid;
      $_SESSION['username'] = $username;
      $_SESSION['islogin'] = true;
      $_SESSION['isadmin'] = $isadmin;

      // Redirect to the stored page or default to products.php
      $redirect_page = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'products.php';
      unset($_SESSION['redirect_after_login']); // Clear the redirect session variable

      echo "<script>
                    window.location.href = '$redirect_page';
                  </script>";
      exit();
    } else {
      echo "<script>
                    alert('Invalid username or password.');
                    window.location.href = 'login.php';
                  </script>";
    }
  } else {
    echo "<script>
                alert('Invalid username or password.');
                window.location.href = 'login.php';
              </script>";
  }

  $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <style>
    .login-wrapper {
      width: 300px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    h1 {
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 5px;
    }

    .login_box {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 15px;
    }

    .login_btn {
      margin-top: 5px;
      padding: 12px;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="main_wrapper" style="padding: 80px 0px;">
    <div class="container">
      <div class="login-wrapper">
        <h1>Login</h1>
        <form action="./login.php" method="post">
          <label for="username">Username:</label>
          <input class="login_box" type="text" id="username" name="username" required />

          <label for="password">Password:</label>
          <input class="login_box" type="password" id="password" name="password" required />
          <div id="error" style="color: red;"></div>
          <button class="login_btn" type="submit">Login</button>
          <a href="./register.php" style="text-align: center; margin-top: 15px;">Don't have an account?
            <u>Register!</u></a>
        </form>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>