<?php

include_once('../cartClass.php');
session_start();

if (!isset($_GET['which']) || !isset($_GET['index'])) {
	die(json_encode(array('status' => 'Failed', 'error' => 'Parameters not set correctly')));
}

$cart = unserialize($_SESSION['cart']);

$i = $_GET['index'];
if ($_GET['which'] === 'Trip') {
  $cart->deleteTrip($i);
} else if ($_GET['which'] === 'Product') {
  $cart->deleteProduct($i);
} else {
  die(json_encode(array('status' => 'Failed', 'error' => '\'which\' parameter invalid')));
}

$_SESSION['cart'] = serialize($cart);
echo json_encode(array('status' => 'Success'));

?>
