<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <title>GQZ TRAVELS - Delivery Service</title>
  <style>
    /*.store > * {
      
    }*/
  </style>
  <script>
    window.onload = function () {
      populateStores();
    };
    
    function populateStores() {
      var xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'retrievestores.php', true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        var response = JSON.parse(this.responseText);
        if (response.status === 'Failure') {
          alert('Store list lookup returned a failure. Check the console for ' +
            'more information');
          console.log(response.error);
        }
        response = response.results;
        var target = document.getElementById('store-container');
        for (var store of response) {
          target.innerHTML +=
            '<div id="store-'+store.id+'" class="floating store">'+
              '<h3>'+store.storeName+'</h3>'+ 
            '</div>'+
            '<br />';
          populateProducts(store, 'store-'+store.id);
        }
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function (e) {
        alert('Failed to retrieve store list. Please try reloading the page');
        console.log(e);
      }
      xhttp.send();
    }
    
    function populateProducts(store, target_id) {
      var xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'retrieveproducts.php?storeId=' + store.id, true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        var response = JSON.parse(this.responseText);
        if (response.state === 'Failure') {
          alert('Failed to retrieve product list for ' + store.storename + '.');
          console.log(response.error);
        }
        response = response.results;
        
        for (var product of response) {
          //console.log(target);
          document.getElementById(target_id).innerHTML +=
            '<p>' + product.description + '</p>';
        }
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function (e) {
        alert('Failed to retrieve product list for ' + store.storeName +
          '. Please try reloading the page');
        console.log(e);
      }
      xhttp.send();
    }
  </script>
</head>
<body>
  <div id="outer">
    <div id="inner" class="floating">
      <!-- Navigation -->
      <?php include('navbar.php'); ?>

      <h1>Online Shopping and Delivery Service</h1>
      <h2>
        Select products from your favorite stores and drag them to your cart
      </h2>
      <br />
      <div id="store-container"></div>
    </div>
  </div>
</body>
</html>
