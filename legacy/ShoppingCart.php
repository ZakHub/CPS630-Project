<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <?php $cart = unserialize($_SESSION['cart']); ?>
  <title>GQZ TRAVELS - Shopping Cart</title>
  <script>
    function deleteFromCart(e) {
      var xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'api/removefromcart.php?which='+e.dataset.which+'&index='+e.dataset.index, true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status != 200) {
          return;
        }
        console.log(this.responseText);
        const response = JSON.parse(this.responseText);
        if (response.status === 'Success') {
          location.reload();
        } else {
          console.error(response.error);
          alert('Failed to remove item from shopping cart. Check console for details');
          return;
        }
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function () {
        alert('Failed to remove item from shopping cart. Request timed out.');
      };
      xhttp.send();
    }
    
    function checkout() {
      var xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'api/checkout.php', true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        const response = JSON.parse(this.responseText);
        if (response.status === "Success") {
          location.href = 'CheckedOut.php?orderId=' + response.content;
        } else {
          alert('There was an error processing your transaction. See the ' + 
            'console for details');
          console.error(response.error);
        }
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function () {
        alert('Checkout request timed out. You have not been charged.');
      };
      xhttp.send();
    }
  </script>
</head>
<body>
  <div id="outer">
    <div id="inner" class="floating">
      <?php include('navbar.php'); ?>
<?php if (isset($_SESSION['id'])): ?>
      <h1>Shopping Cart</h1>
<?php if ($cart->isEmpty()): ?>
      <br />
      <h2>Empty cart</h2>
<?php else: ?>
<?php if (!empty($cart->getProducts())): ?>
      <br />
      <h2>Products</h2>
      <div id="products">
        <table>
          <tr>
            <th>Delete</th>
            <th>Product Description</th>
            <th>Price</th>
          </tr>
<?php foreach ($cart->getProducts() as $index => $product): ?>
          <tr>
            <td><button type="button" onclick="deleteFromCart(this);"
              data-which="Product" data-index="<?= $index ?>">Delete</button></td>
            <td><?= $product->description ?></td>
            <td>$<?= number_format($product->price, 2) ?></td>
          </tr>
<?php endforeach; ?>
        </table>
      </div>
<?php endif; ?>
      
<?php if (!empty($cart->getTrips())): ?>
      <br />
      <h2>Trips</h2>
      <div id="trips">
        <table>
          <tr>
            <th>Delete</th>
            <th>Distance</th>
            <th>Price</th>
          </tr>
<?php foreach ($cart->getTrips() as $index => $trip): ?>
          <tr>
            <td><button type="button" onclick="deleteFromCart(this);"
              data-which="Trip" data-index="<?= $index ?>">Delete</button></td>
            <td><?= $trip->distance ?> Km</td>
            <td>$<?= number_format($trip->price, 2) ?></td>
          </tr>
<?php endforeach; ?>
        </table>
      </div>
<?php endif; ?>
      <p><strong>Total:</strong> $<?= $cart->getTotalPrice() ?></p>
      <button type="button" onclick="checkout();">Check Out</button>
<?php endif; ?>
<?php else: ?>
      <script>
        function redirect () {
          location.href = 'login.html';
        }
        window.onload = function () {
          setTimeout(redirect, 2000);
        }
      </script>
      <p>Redirecting you to the login page shortly.</p>
      <p>If you are not being redirected, please click here to go to login page</p>
      <button type="button" onclick="redirect();">Go to login page</button>
<?php endif; ?>
    </div>
  </div>
</body>
</html>
