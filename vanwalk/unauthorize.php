<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <style>
    .login-wrapper {
      width: 80%;
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
        <h1>Please log in as admin user to visit the page!</h1>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>