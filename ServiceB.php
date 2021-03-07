<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
<?php if (isset($_SESSION['id'])): ?>
  <title>GQZ TRAVELS - Delivery Service</title>
  <style>
    .store > * {
      padding: 2vh 2vw;
    }
    
    .draggable {
      cursor: grab;
    }
    
    .draggable:active {
      background: lightgrey;
      cursor: grabbing;
    }
    
    .noselect {
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -o-user-select: none;
      user-select: none;
    }
    
    .centered {
      text-align: center;
    }
    
    #overlay {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    
    #overlay img {
      position: fixed;
      bottom: 0;
      right: 0;
      padding: 5%;
    }
    
    #cart {
      width: 10vw;
      height: auto;
    }
  </style>
  <script>
    window.onload = function () {
      populateStores();
    };
    
    function populateStores() {
      var xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'api/retrievestores.php', true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        var response = JSON.parse(this.responseText);
        if (response.status === 'Failed') {
          alert('Store list lookup returned a failure. Check the console for ' +
            'more information');
          console.log(response.error);
          return;
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
      xhttp.open('GET', 'api/retrieveproducts.php?storeId=' + store.id, true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        var response = JSON.parse(this.responseText);
        if (response.state === 'Failed') {
          alert('Failed to retrieve product list for ' + store.storename + '.');
          console.log(response.error);
        }
        response = response.results;
        
        var productTableHTML =
          '<table class="centered" style="width: 100%;">'+
            '<tr>'+
              '<th>Description</th>'+
              '<th>Price</th>'+
              '<th>Drag to cart</th>'+
            '</tr>';
        for (var product of response) {
          //console.log(target);
          productTableHTML +=
            //'<p>' + product.description + '</p>';
            '<tr>'+
              '<td>'+product.description+'</td>'+
              '<td>$'+product.price.toFixed(2)+'</td>'+
              '<td class="draggable noselect" draggable="true" '+
                //'ondragstart="drag(event);" data-id="'+product.id+'">'+
                'ondragstart="drag(event);" data-json=\''+JSON.stringify(product)+'\'>'+
                'Drag Me'+
              '</td>'+
            '</tr>';
        }
        productTableHTML += '</table>';
        
        document.getElementById(target_id).innerHTML += productTableHTML;
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function (e) {
        alert('Failed to retrieve product list for ' + store.storeName +
          '. Please try reloading the page');
        console.log(e);
      }
      xhttp.send();
    }
  
    function allowDrop(ev) {
      ev.preventDefault();
    }
    
    function drag(ev) {
      ev.dataTransfer.setData('text/plain', ev.target.dataset.json);
    }
    
    function drop(ev) {
      ev.preventDefault();
      var productJSON = ev.dataTransfer.getData('text');
      addToCart(productJSON);
    }
    
    function addToCart(productJSON) {
      //console.log(productJSON);
      //var product = JSON.parse(productJSON);
      //console.log(product);
      
      // create php API to add product to cart
      // show notification that product added successfully
      const request = {
        type: 'Product',
        content: JSON.parse(productJSON)
      };
      var xhttp = new XMLHttpRequest();
      xhttp.open('POST', 'api/addtocart.php', true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        console.log(this.responseText);
        //if (this.
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function (e) {
        alert('Failed to add item to cart. Please refresh the page and try again.');
        console.log(e);
      }
      xhttp.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
      xhttp.send(JSON.stringify(request));
    }
  </script>
</head>
<body>
  <div id="overlay">
    <img id="cart" alt="shopping cart" src="cart.png"
      ondragover="allowDrop(event);" ondrop="drop(event);" />
  </div>
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
      
      <div id="attribution" style="position: fixed; bottom: 0;">
        Icons made by <a href="https://www.freepik.com" title="Freepik">
          Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">
          www.flaticon.com</a>
      </div>
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
