<!-- Module containing a common nav bar -->
<nav class="nav">
  <img src="Logo2.png" width="80" height="100"
    class="d-inline-block align-top" alt="logo"/>
  <a href="CPS630ProjectMain.php">Home</a>
<?php if (!isset($_SESSION['id'])): ?>
  <a href="SignUp.html">Sign Up</a>
<?php endif; ?>
<?php if (isset($_SESSION['username'])): ?>
  <a href="logout.php">Log Out</a>
<?php else: ?>
  <a href="login.html">Log In</a>
<?php endif; ?>
  <a href="AboutUs.php">About Us</a>
  <a href="ContactUs.php">Contact Us</a>
  <a href="Reviews.php">Reviews</a>
  <a href="ShoppingCart.php">Shopping Cart</a>
  <a href="TypesOfServices.php">Types of Services</a>
<?php if (isset($_SESSION['id']) && $_SESSION['id'] == 1): ?>
  <div class="dropdown">
    <button class="dropbtn">db Maintain</button>
    <div class="dropdown-content">
      <a href="insert.php" target="_blank">Insert</a>
      <a href="delete.php" target="_blank">Delete</a>
      <a href="update.php" target="_blank">Update</a>
      <a href="select.php" target="_blank">Select</a>
    </div>
  </div>
<?php endif; ?>
<?php if (isset($_SESSION['id'])): ?>
  <div style="float: right; padding: 2%;">
    <form method="GET" action="Search.php">
      <input id="search" name="search" type="number" placeholder="Search" />
      <input type="submit" />
    </form>
  </div>
<?php endif; ?>
</nav>
