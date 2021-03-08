<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
<?php if (isset($_SESSION['id'])): ?>
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
    table, td, th {
      border: 1px solid black;
      border-collapse: collapse;
    }
    td, th {
      padding: 5px;
    }
  </style>
  <script>
    var field_suffixes = [ '-street', '-city', '-province', '-country' ];
    const osm = 'https://nominatim.openstreetmap.org';
    const defaultZoom = 12;
    var map = null;
    var route = null;
    var routeConfirmed = false;

    window.onload = function () {
      restrictDate(document.getElementById('fulfillment-date'), 'min');
      
      initMap();
    }
    
    function restrictDate(element, which) {
      const today = new Date();
      var dd = today.getDate();
      if (dd < 10) {
        dd = '0'+dd;
      }
      var mm = today.getMonth() + 1;
      if (mm < 10) {
        mm = '0' + mm;
      }
      const yyyy = today.getFullYear();
      todayDate = yyyy+'-'+mm+'-'+dd;
      element.setAttribute(which, todayDate);
    }
    
    function initMap() {
      var target = document.getElementById('map-holder');
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
    
    function updateCost() {
      const carInput = document.querySelector('input[name="car-id"]:checked');
      if (!carInput) {
        return;
      }
      const rate = parseFloat(carInput.dataset.rate);
      const cost = (distance * rate / 1000).toFixed(2);
      var distanceElement = document.getElementById('distance');
      distanceElement.dataset.distance = (distance / 1000).toFixed(2);
      distanceElement.innerHTML = (distance / 1000).toFixed(2) + ' Km';
      var costElement = document.getElementById('cost');
      costElement.dataset.cost = cost;
      costElement.innerHTML = '$' + cost;
    }
    
    async function addressLookup(address) {
      return new Promise(function (resolve, reject) {
        var response;

        var xhttp = new XMLHttpRequest();
        xhttp.open('GET', osm + '/search?format=json&q=' + address, true);
        xhttp.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
            resolve(JSON.parse(this.responseText));
          }
        };
        xhttp.timeout = 2000;
        xhttp.ontimeout = function (e) {
          //reject(this.status);
          reject(null);
        };
        xhttp.send();
      });
    }
    
    async function updateRoute() {
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
      
      const fromResponse = await fromResponsePromise;
      if (!fromResponse) {
        console.warn('Starting address query did not return a location');
        return;
      }
      
      const toResponse = await toResponsePromise;
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
      if (!route) {
        route = L.Routing.control({
          waypoints: [ fromPos, toPos ],
          show: false
        }).on('routesfound', function (e) {
          const routes = e.routes;
          distance = routes[0].summary.totalDistance;
          if (distance > 50000) {
            alert('Requested route exceeds transport limit of 50Km.');
            routeConfirmed = false;
          } else {
            routeConfirmed = true;
          }
        }).on('routeselected', function (e) {
          updateCost();
        });
        route.addTo(map);
      } else {
        route.setWaypoints([ fromPos, toPos ]);
      }
    }
    
    function populateVehicles() {
      function reportError(e) {
        alert('Failed to retrieve available cars. Additional details can be \
          found inthe console');
        console.error(e);
      }
      
      // retrieve list of vehicles available on selected date
      var date = document.getElementById('fulfillment-date').value;
      var xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'api/retrievecars.php?date=' + date, true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        var response = JSON.parse(this.responseText);
        if (response.status === 'Failure') {
          reportError(e);
          return;
        }
        response = response.results;
        
        html = document.getElementById('car-header').innerHTML;
        for (var car of response) {
          html += '<tr>';
          html += '<td><input id="car-id-'+car.id+'" name="car-id" type="radio" value="'+car.id+'" data-rate="'+car.rate+'" /></td>';
          html += '<td><label for="car-id-'+car.id+'">'+car.model+'</label></td>';
          html += '<td>$'+car.rate.toFixed(2)+'</td>';
          html += '</tr>';
        }
        document.getElementById('available-cars').innerHTML = html;
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function (e) {
        reportError(e);
        return;
      };
      
      xhttp.send();
    }
    
    function addToCart() {
      console.log('addToCart() called');
      if (!routeConfirmed) {
        alert('Update the map before adding this route to your cart');
        return;
      }
      const dateInput = document.getElementById('fulfillment-date');
      if (!dateInput || !dateInput.value) {
        alert('Select a date for the order to be fulfilled before adding ' +
          'this route to your cart');
        return;
      }
      const carInput = document.querySelector('input[name="car-id"]:checked');
      console.log(carInput);
      if (!carInput || !carInput.value) {
        alert('Select a car before adding the route to your card');
        return;
      }
      if (!confirm('Add this trip to cart?')) {
        return;
      }
      
      const waypoints = route.options.waypoints;
      const trip = {
        fromLat: waypoints[0].lat,
        fromLng: waypoints[0].lng,
        toLat: waypoints[1].lat,
        toLng: waypoints[1].lng,
        distance: document.getElementById('distance').dataset.distance,
        carId: carInput.value,
        price: document.getElementById('cost').dataset.cost,
        fulfillmentDate: document.getElementById('fulfillment-date').value
      };
      console.log(trip);
      
      const request = {
        type: "Trip",
        content: trip
      };
      var xhttp = new XMLHttpRequest();
      xhttp.open('POST', 'api/addtocart.php');
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        const response = JSON.parse(this.responseText);
        if (response.status === 'Success') {
          //alert('Success');
          if (confirm('Success. Go to cart?')) {
            location.href = 'ShoppingCart.php';
          }
        } else {
          alert('Failed to add trip to cart. Check console for details.');
          console.error(response.error);
        }
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function (e) {
        alert('Failed to add item to cart. Please refresh the page and try again.');
        console.log(e);
      }
      xhttp.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
      xhttp.send(JSON.stringify(request));
      
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
      </div>
<?php endforeach; ?>
      <br />
      <label for="order-date"><strong>Order Date: </strong></label>
      <input name="fulfillment-date" id="fulfillment-date" type="date"
        min="1970-01-01" onchange="populateVehicles();" />
      <h3>Available vehicles</h3>
      <p>Select a date to list available vehicles</p>
      <table id="available-cars">
        <tr id="car-header">
          <th>Select</th>
          <th>Model</th>
          <th>Rate ($/Km)</th>
        </tr>
        <!-- sample row -->
        <!--<tr>
          <td><input id="car-id-1" name="car-id" type="radio" value="1"
            data-rate="3.00" /></td>
          <td><label for="car-id-1">2001 Toyota Corolla</label></td>
          <td>$3.00</td>
        </tr>-->
      </table>
      <br />
      <div>
        <strong>Distance: </strong>
        <p id="distance" data-distance="" style="display: inline"></p>
        <br />
        <strong>Total: </strong>
        <p id="cost" data-cost="" style="display: inline"></p>
      </div>
      <br />
      
      <button type="button" onclick="updateRoute();">Update</button>
      <button type="button" onclick="addToCart();">Add to cart</button>
    </div>
  </div>
</body>
<?php else: ?>
  <script>
    function redirect() {
      location.href = 'login.html';
    }
    
    window.onload = function () {
      setTimeout(redirect, 2000);
    };
  </script>
</head>
<body>
  <p>Redirecting you to the login page shortly.</p>
  <p>If you are not being redirected, please click here to go to login page</p>
  <button type="button" onclick="redirect();">Go to login page</button>
</body>
<?php endif; ?>
</html>
