<?php

include('../cartClass.php');
session_start();

$cart = $_SESSION['cart'];

//echo json_encode($_SESSION);
$req = json_decode(file_get_contents('php://input'));

$return = array('status' => 'Success');
if ($req->type == 'Trip') {
	$trip = $req->content;
	$cart->addTrip($trip);
	echo json_encode($return);
} else if ($req->type == 'Product') {
	$product = $req->content;
	$cart->addProduct($product);
	echo json_encode($return);
} else {
	echo json_encode(array('status' => 'Failure', 'error' => 'Unsupported service type.'));
}

echo json_encode($cart);
$_SESSION['cart'] = $cart;

?>
