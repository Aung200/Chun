<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vanwalk</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="./css/index.css" />
  <link rel="stylesheet" type="text/css" href="./css/header-footer.css" />
  <!-- Swiper CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <!-- Swiper JavaScript -->
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script>
    // Initialize Swiper
    document.addEventListener("DOMContentLoaded", function() {
      var swiper = new Swiper(".swiper-container", {
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        loop: true, // Enable infinite loop
        autoplay: {
          delay: 5000, // Slide change interval
        },
      });
    });
  </script>
  <style>
    .swiper_img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .swiper-container {
      position: relative;
      overflow: hidden;
    }

    .swiper-button-prev,
    .swiper-button-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 10;
      color: #d1e9f6;
    }

    .swiper-button-prev {
      left: 40px;
    }

    .swiper-button-next {
      right: 40px;
    }

    /* Grid Styles */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 10px;
    }

    .grid-item {
      position: relative;
      overflow: hidden;
    }

    .grid-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .grid-text {
      position: absolute;
      top: 85%;
      left: 38%;
      width: 20%;
      padding: 10px;
      color: black;
      text-align: center;
      font-size: 24px;
    }

    .grid-text:hover {
      background-color: #d1e9f6;
      color: black;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="main_wrapper" style="padding: 0px 0px 50px 0px">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a href="./newarrivals.php">
            <img class="swiper_img" src="./public/sarrival.jpg" alt="sarrival" />
          </a>
        </div>
        <div class="swiper-slide">
          <a href="./index.php">
            <img class="swiper_img" src="./public/shome.jpg" alt="shome" />
          </a>
        </div>
        <div class="swiper-slide">
          <a href="./sales.php">
            <img class="swiper_img" src="./public/ssale.jpg" alt="ssale" />
          </a>
        </div>
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
    <div class="container" style="text-align: center">
      <h1>#SLAY THE DAY WITH SIMPLEST PEICE OF CLOTH!</h1>
    </div>
    <div class="grid-container">
      <div class="grid-item">
        <p style="text-align: center">
          Elevate your style, from boardroom to weekend ease.
        </p>
        <img class="grid-img" src="./public/top.jpg" alt="Grid Image 1" />
        <a class="grid-text" href="./tops.php"># Tops</a>
      </div>
      <div class="grid-item">
        <p style="text-align: center">
          Elevate your style, from boardroom to weekend ease.
        </p>
        <img class="grid-img" src="./public/bottom.jpg" alt="Grid Image 2" />
        <a class="grid-text" href="./bottoms.php"># Bottoms</a>
      </div>
      <div class="grid-item">
        <p style="text-align: center">
          Elevate your style, from boardroom to weekend ease.
        </p>
        <img class="grid-img" src="./public/dress.jpg" alt="Grid Image 3" />
        <a class="grid-text" href="./dresses.php"># Dresses</a>
      </div>
    </div>
    <div class="container" style="text-align: center; margin: 80px 0px 50px">
      <h1>#VANWALK</h1>
      <a
        href="./index.php"
        style="font-size: 20px; text-decoration: underline">Follow us on Instagram!</a>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>