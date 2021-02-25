<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GQZ TRAVELS - Types of Services</title>
  <link rel="stylesheet" href="Main.css">
  <style>
    a {
      outline: 2px black;
    }
    
    .service-outer {
      padding: 2%;
    }
    
    .service {
      -webkit-box-shadow: -1px 1px 36px 14px rgba(0,0,0,0.75);
      -moz-box-shadow: -1px 1px 36px 14px rgba(0,0,0,0.75);
      box-shadow: -1px 1px 36px 14px rgba(0,0,0,0.75);
      padding: 10px;
    }
    
    .service:hover {
      background-color: lightgray;
      cursor: pointer;
    }
    
    .service * {
      padding: 0 2%;
    }
  </style>
</head>
<body>
  <div id="outer">
    <div id="inner">
      <!-- Navigation -->
      <?php include('navbar.php'); ?>

      <h1>Types of Services</h1>
      <p>GQZ Offers two types of travel services.</p>
      <div class="service-outer">
        <div class="service" id="service-a"
          onclick="location.href='ServiceA.php';">
          <!--<h3><a href="ServiceA.php">Travel</a></h3>-->
          <h2>Travel</h2>
          <p>Our renowened transport service. We'll take you anywhere within
            50Km. That's enough to get you anywhere in the city.</p>
        </div>
      </div>
      <br />
      <div class="service-outer">
        <div class="service" id="service-b"
          onclick="location.href='ServiceB.php';">
          <!--<h3><a href="ServiceB.php">Delivery</a></h3>-->
          <h2>Delivery</h2>
          <p>Our new delivery service will bring the products you want from the
            partnered stores you love.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
