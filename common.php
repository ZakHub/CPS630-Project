<!-- Common initialization stuff for user-facing pages -->

<?php
  include('cartClass.php');

  ob_start();
  session_start();
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new Cart(); // this doesn't seem to work
  }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Main.css">
