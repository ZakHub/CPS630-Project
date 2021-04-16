<?php

require_once('connect.php');

$order = json_decode(file_get_contents('php://input'));

$orderQuery = 
	'INSERT INTO OrderInfo ' .
	'(orderDate, price, userId) ' .
	'VALUES ' .
	'(NOW(), ?, ?)';

$productQuery = 
	'INSERT INTO OrderedItem ' .
	'(orderId, productId) ' .
	'VALUES ' .
	'(?, ?)';

$tripQuery =
	'INSERT INTO Trip ' .
	'(fromLat, fromLng, toLat, toLng, distance, carId, price, fulfillmentDate) ' .
	'VALUES ' .
	'(?, ?, ?, ?, ?, ?, ?, ?)';

$conn->begin_transaction();
try {
	$stmt = $conn->prepare($orderQuery);
	$stmt->bind_param('di', $order->total, $order->user->id);
	$stmt->execute();
	$orderId = $conn->insert_id;
	$stmt->close();
	
	$stmt = $conn->prepare($productQuery);
	foreach ($order->cart->products as &$product) {
		$stmt->bind_param('ii', $orderId, $product->id);
		$stmt->execute();
	}
	$stmt->close();
	
	$stmt = $conn->prepare($tripQuery);
	foreach ($order->cart->trips as &$trip) {
		$date = substr($trip->date, 0, strpos($trip->date, 'T'));    // ugly hack
		$stmt->bind_param('dddddids', $trip->fromPos->lat, $trip->fromPos->lng,
			$trip->toPos->lat, $trip->toPos->lng, $trip->distance,
			$trip->car->id, $trip->cost,
			$date);
		$stmt->execute();
	}
	$stmt->close();
	$conn->commit();
	respond(200, json_encode(array('orderId' => $orderId)));
} catch (mysqli_sql_exception $e) {
	$conn->rollback();
	respond(500, constructError($e));
}

$conn->close();

?>
