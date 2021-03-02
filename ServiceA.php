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
      margin: 1%;
      display: table-cell;
    }
    #map-holder {
      width: 50%;
      height: 40vh;
    }
  </style>
  <script>
    const osm = 'https://nominatim.openstreetmap.org';
    function initMap() {
      var target = document.getElementById('map-holder');
      var map = new google.maps.Map(target, { zoom: 12, center: {lat: 37.4, lng: -122.1}});
      
      if (!navigator.geolocation) {
        console.warn('geolocation is not supported');
        return;
      }
      
      navigator.geolocation.getCurrentPosition(function (loc) {
        const pos = {
          lat: loc.coords.latitude,
          lng: loc.coords.longitude
        };
        map.setOptions({ center: pos });
        
        var xhttp = new XMLHttpRequest();
        xhttp.open('GET', osm + '/reverse?lat=' + pos.lat + '&lon=' + pos.lng +
          '&format=json', true);
        xhttp.onreadystatechange = function () {
          if (this.readyState !== 4 || this.status !== 200) {
            return;
          }
          const response = JSON.parse(this.responseText);
          const address = response.address;
          console.log(response);
          
          document.getElementById('from-street').value = address.house_number +
            ' ' + address.road;
          document.getElementById('from-city').value = address.city;
          document.getElementById('from-province').value = address.state;
          document.getElementById('from-country').value = address.country;
          document.getElementById('from-postal-code').value = address.postcode;
        };
        xhttp.send();
      });
    }
    
    function updateMap() {
      console.log('updateMap() called');
    }
    
    function addToCart() {
      if (!confirm('Add this trip to cart?')) {
        return;
      }
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
          <input id="<?= $loc ?>-province" type="text" />
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
      <button type="button" onclick="addToCart();">Add to cart</button>
    </div>
  </div>
  
  <!-- map initialization script for google maps -->
  <script async src="https://maps.googleapis.com/maps/api/js?key=<?php
    include('key.txt'); ?>&callback=initMap"></script>
</body>
</html>
