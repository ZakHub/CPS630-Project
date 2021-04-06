<?php

include_once('../cartClass.php');
session_start();

$cart = unserialize($_SESSION['cart']);
$req = json_decode(file_get_contents('php://input'));

$return = array('status' => 'Success');
$fail = array('status' => 'Failure', 'error' => 'Unsupported service type.');
if ($req->type == 'Trip') {
	$trip = $req->content;
	$cart->addTrip($trip);
	echo json_encode($return);
} else if ($req->type == 'Product') {
	$product = $req->content;
	$cart->addProduct($product);
	echo json_encode($return);
} else {
	echo json_encode($fail);
}

$_SESSION['cart'] = serialize($cart);

?>
