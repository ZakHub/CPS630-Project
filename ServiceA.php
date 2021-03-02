<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <title>GQZ TRAVELS - Travel Service</title>
  <style>
    .address-input {
      display: table;
    }
    .address-input p {
      display: table-row;
    }
    .address-input label, .address-input input {
      /*padding: 1%;*/
      display: table-cell;
    }
    #map-holder {
      width: 50%;
      height: 40vh;
    }
  </style>
  <script>
    function initMap() {
      //var location = null;

      var target = document.getElementById('map-holder');
      //console.log(target);
      var map = new google.maps.Map(target, { zoom: 12, center: {lat: 37.4, lng: -122.1}});
      
      if (!navigator.geolocation) {
        console.warn('geolocation is not supported');
        return;
      }
      
      var infoWindow = new google.maps.InfoWindow();
      navigator.geolocation.getCurrentPosition(function (loc) {
        //location = loc;
        const pos = {
          lat: loc.coords.latitude,
          lng: loc.coords.longitude
        };
        infoWindow.setPosition(pos);
      });
    }
    
    function updateMap() {
      console.log('updateMap() called');
    }
  </script>
</head>
<body>
  <div id="outer">
    <div id="inner" class="floating">
      <!-- Navigation -->
      <?php include('navbar.php'); ?>
      
      <h1>Travel Service</h1>
      <h2>Enter your starting location and destination</h2>
      <br />
      <div id="map-holder" style="float: right;"></div>
<?php
  $addr_headers = array('from' => 'Starting', 'to' => 'Destination');
?>
<?php foreach (array('from', 'to') as &$loc): ?>

      <h3><?= $addr_headers[$loc] ?> address</h3>
      <div id="<?= $loc ?>-address" class="address-input">
        <p>
          <label for="<?= $loc ?>-street">Street address</label>
          <input id="<?= $loc ?>-street" type="text" />
        </p>
        <p>
          <label for="<?= $loc ?>-city">City</label>
          <input id="<?= $loc ?>-city" type="text" />
        </p>
        <p>
          <label for="<?= $loc ?>-province">Province</label>
          <input id="<?= $loc ?>-provice" type="text" />
        </p>
        <p>
          <label for="<?= $loc ?>-country">Country</label>
          <input id="<?= $loc ?>-country" type="text" />
        </p>
        <p>
          <label for="<?= $loc ?>-postal-code">Postal Code</label>
          <input id="<?= $loc ?>-postal-code" type="text" />
        </p>
      </div>
<?php endforeach; ?>
      <br />
      <button type="button" onclick="updateMap();">Update</button>
      <button type="button">Add to cart</button>
    </div>
  </div>
  
  <!-- map initialization script for google maps -->
  <script async src="https://maps.googleapis.com/maps/api/js?key=<?php
    include('key.txt'); ?>&callback=initMap"></script>
</body>
</html>
