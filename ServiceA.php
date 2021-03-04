<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
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
    var field_suffixes = [ '-street', '-city', '-province', '-country' ]; /*,
      '-postal-code' ];*/
    const osm = 'https://nominatim.openstreetmap.org';
    const defaultZoom = 12;
    var map = null;
    var routeConfirmed = false;
    
    //function initMap() {
    window.onload = function() {
      var target = document.getElementById('map-holder');
      //map = new google.maps.Map(target, { zoom: defaultZoom, center: {lat: 37.4, lng: -122.1}});
      //map = new google.maps.Map(target, { zoom: defaultZoom });
      map = L.map('map-holder').setView([ 37.4, -122.1 ], defaultZoom);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      
      if (!navigator.geolocation) {
        console.warn('geolocation is not supported');
        return;
      }
      
      navigator.geolocation.getCurrentPosition(function (loc) {
        const pos = {
          lat: loc.coords.latitude,
          lng: loc.coords.longitude
        };
        //map.setOptions({ center: pos });
        //map.setView(pos, defaultZoom);
        map.panTo(pos);
        
        var xhttp = new XMLHttpRequest();
        xhttp.open('GET', osm + '/reverse?lat=' + pos.lat + '&lon=' + pos.lng +
          '&format=json', true);
        xhttp.onreadystatechange = function () {
          if (this.readyState !== 4 || this.status !== 200) {
            return;
          }
          const response = JSON.parse(this.responseText);
          const address = response.address;
          
          document.getElementById('from-street').value = address.house_number +
            ' ' + address.road;
          document.getElementById('from-city').value = address.city;
          document.getElementById('from-province').value = address.state;
          document.getElementById('from-country').value = address.country;
          //document.getElementById('from-postal-code').value = address.postcode;
          
          document.getElementById('to-province').value = address.state;
          document.getElementById('to-country').value = address.country;
        };
        xhttp.send();
      });
    }
    
    function verifyAddress(prefix) {
      for (suffix of field_suffixes) {
        if (!document.getElementById(prefix + suffix).value) {
          return false;
        }
      }
      return true;
    }
    
    function constructAddress(prefix) {
      if (!verifyAddress(prefix)) {
        return null;
      }
      var addr = '';
      for (var i = 0; i < field_suffixes.length; i++) {
        if (i) {
          addr += ', ';
        }
        addr += document.getElementById(prefix+field_suffixes[i]).value;
      }
      return addr;
    }
    
    async function addressLookup(address) {
      return new Promise(function (resolve, reject) {
        var response;

        var xhttp = new XMLHttpRequest();
        xhttp.open('GET', osm + '/search?format=json&q=' + address, true);
        //xhttp.open('GET', osm + '/search?format=json&q=' + address, false);
        xhttp.onreadystatechange = function () {
          //if (this.readyState !== 4 || this.status !== 200) {
          if (this.readyState === 4 && this.status === 200) {
            resolve(this.responseText);
          }
        };
        xhttp.timeout = 2000;
        xhttp.ontimeout = function (e) {
          reject(this.status);
        };
        xhttp.send();
      });
    }
    
    async function updateMap() {
      console.log('updateMap() called');
      
      const from = constructAddress('from');
      const to = constructAddress('to');
      if (from === null) {
        alert('Starting address is not correctly populated.');
        return;
      } else if (to === null) {
        alert('Destination address is not correctly populated.');
        return;
      }
      
      const fromResponsePromise = addressLookup(from);
      const toResponsePromise = addressLookup(to);
      
      const fromResponse = JSON.parse(await fromResponsePromise);
      if (!fromResponse) {
        console.warn('Starting address query did not return a location');
        return;
      }
      
      const toResponse = JSON.parse(await toResponsePromise);
      if (!toResponse) {
        console.warn('Destination address query did not return a location');
        return;
      }
      
      const fromPos = {
        lat: parseFloat(fromResponse[0].lat),
        lng: parseFloat(fromResponse[0].lon)
      };
      const toPos = {
        lat: parseFloat(toResponse[0].lat),
        lng: parseFloat(toResponse[0].lon)
      };
      
      map.panTo(fromPos);

      // add route to map
      
      routeConfirmed = true;
    }
    
    function addToCart() {
      console.log('addToCart() called');
      if (!routeConfirmed) {
        alert('Update the map before adding this route to your cart');
      }
      if (!confirm('Add this trip to cart?')) {
        return;
      }
      
      
      
      routeConfirmed = false;
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
        <!--<p>
          <label for="<?= $loc ?>-postal-code">Postal Code</label>
          <input id="<?= $loc ?>-postal-code" type="text" />
        </p>-->
      </div>
<?php endforeach; ?>
      <br />
      <button type="button" onclick="updateMap();">Update</button>
      <button type="button" onclick="addToCart();">Add to cart</button>
    </div>
  </div>
  
  <!-- map initialization script for google maps -->
  <!--<script async src="https://maps.googleapis.com/maps/api/js?key=<?php
    include('key.txt'); ?>&callback=initMap"></script>-->
</body>
</html>
