<!-- Module containing a common nav bar -->
<?php
ob_start();
session_start();
?>
<style>
    .dropbtn {
        //background-color: #4CAF50;
        //color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: #f1f1f1}

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        //background-color: #3e8e41;
    }
</style>
<nav class="nav">
  <img src="Logo2.png" width="80" height="100"
    class="d-inline-block align-top" alt="logo"/>
  <a href="CPS630ProjectMain.php">Home</a>
  <a href="SignUp.html">Sign Up</a>
   <?php
    if(isset($_SESSION['username'])){
        echo '<a href="logout.php">Log Out</a>';
    }else{
        echo '<a href="login.html">Log In</a>';
    }
   ?>

  <a href="AboutUs.php">About Us</a>
  <a href="ContactUs.php">Contact Us</a>
  <a href="Review.html" >Reviews</a>
  <a href="ShoppingCart.html" >Shopping Cart</a>
  <a href="TypesOfServices.php">Types of Services</a>
 <?php
 if(isset($_SESSION['id'])) {
 if ($_SESSION['id'] == 1) {
     echo '<div class="dropdown"><button class="dropbtn">db Maintain</button>
                    <div class="dropdown-content">
                     <a href=insert.html">Insert</a>
                     <a href="delete.html">Delete</a>
                    <a href="update.html">Update</a>
                    <a href="select.html">Select</a>
                </div>
                </div>
                ';

 }
 }
 ?>
</nav>
