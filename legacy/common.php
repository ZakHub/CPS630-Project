<!-- Common initialization stuff for user-facing pages -->

<?php
  include('cartClass.php');

  ob_start();
  session_start();
  if (isset($_SESSION['id']) && !isset($_SESSION['cart'])) {
    //$_SESSION['cart'] = new Cart(); // this kind of works. need ShoppingCart.php to test
    $cart = new Cart();
    $_SESSION['cart'] = serialize($cart);
  }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Main.css">
