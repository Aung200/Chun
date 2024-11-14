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
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Check if passwords match
  if ($password !== $confirm_password) {
    echo "<script>
                alert('Passwords do not match.');
                window.location.href = 'register.php';
              </script>";
    exit();
  }

  // Hash the password for security
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Function to generate a unique 3-digit User ID
  function generateUniqueId($conn, $tableName, $columnName)
  {
    do {
      $id = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
      $result = mysqli_query($conn, "SELECT * FROM $tableName WHERE $columnName = '$id'");
    } while (mysqli_num_rows($result) > 0);
    return $id;
  }

  $userid = generateUniqueId($conn, 'User', 'Userid');
  $isadmin = 0;

  // Insert user details into the database
  $sql = "INSERT INTO User (Userid, Username, Password, Email, isadmin) VALUES ('$userid', '$name', '$hashed_password', '$email', '$isadmin')";

  if (mysqli_query($conn, $sql)) {
    // Set session variables
    $_SESSION['userid'] = $userid;
    $_SESSION['username'] = $name;
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
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <style>
    .register-wrapper {
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

    .register_box {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 10px;
    }

    .register_btn {
      margin-top: 10px;
      padding: 12px;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="main_wrapper" style="padding: 80px 0px;">
    <div class="container">
      <div class="register-wrapper">
        <h1>Register</h1>
        <form action="./register.php" method="post" id="registerForm">
          <label for="email">Email:</label>
          <input
            class="register_box"
            type="email"
            id="email"
            name="email"
            required />

          <label for="name">Name:</label>
          <input
            class="register_box"
            type="text"
            id="name"
            name="name"
            required />

          <label for="password">Password:</label>
          <input
            class="register_box"
            type="password"
            id="password"
            name="password"
            required />

          <label for="confirm_password">Confirm Password:</label>
          <input
            class="register_box"
            type="password"
            id="confirm_password"
            name="confirm_password"
            required />
          <div id="error" style="margin-bottom: 20px;color: red;"></div>

          <button class="register_btn" type="submit">Register</button>
          <a href="./login.php" style="text-align: center; margin-top: 15px;">Already Registered! <u>Login</u> here!</a>
        </form>
        <script>
          document.getElementById('registerForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var errorDiv = document.getElementById('error');

            if (password !== confirmPassword) {
              event.preventDefault();
              errorDiv.textContent = 'Passwords do not match.';
            }
          });
        </script>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>