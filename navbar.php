<!-- Module containing a common nav bar -->
<nav class="nav">
  <img src="Logo2.png" width="80" height="100"
    class="d-inline-block align-top" alt="logo"/>
  <a href="CPS630ProjectMain.php">Home</a>
  <a href="SignUp.html">Sign Up</a>
<?php if (isset($_SESSION['username'])): ?>
  <a href="logout.php">Log Out</a>
<?php else: ?>
  <a href="login.html">Log In</a>
<?php endif; ?>
  <a href="AboutUs.php">About Us</a>
  <a href="ContactUs.php">Contact Us</a>
  <a href="Review.html" >Reviews</a>
  <a href="ShoppingCart.html" >Shopping Cart</a>
  <a href="TypesOfServices.php">Types of Services</a>
<?php if (isset($_SESSION['id']) && $_SESSION['id'] == 1): ?>
  <div class="dropdown">
    <button class="dropbtn">db Maintain</button>
    <div class="dropdown-content">
      <a href=insert.html">Insert</a>
      <a href="delete.php">Delete</a>
      <a href="update.php">Update</a>
      <a href="select.php">Select</a>
    </div>
  </div>
<?php endif; ?>
</nav>
