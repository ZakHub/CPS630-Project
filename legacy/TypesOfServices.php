<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <title>GQZ TRAVELS - Types of Services</title>
  <style>
    .service-outer {
      padding: 2%;
    }
    
    .service {
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
    <div id="inner" class="floating">
      <!-- Navigation -->
      <?php include('navbar.php'); ?>

      <h1>Types of Services</h1>
      <p>GQZ Offers two types of travel services.</p>
      <div class="service-outer">
        <div id="service-a" class="service floating"
          onclick="location.href='ServiceA.php';">
          <h2>Travel</h2>
          <p>Our renowened transport service. We'll take you anywhere within
            50Km. That's enough to get you anywhere in the city.</p>
        </div>
      </div>
      <br />
      <div class="service-outer">
        <div id="service-b" class="service floating"
          onclick="location.href='ServiceB.php';">
          <h2>Delivery</h2>
          <p>Our new delivery service will bring the products you want from the
            partnered stores you love.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
