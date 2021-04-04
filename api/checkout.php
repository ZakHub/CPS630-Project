<?php

include_once('../cartClass.php');
include_once('connect.php');

session_start();
$cart = unserialize($_SESSION['cart']);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->begin_transaction();

$success = array('status' => 'Success');
if (!isset($_SESSION['id'])) {
  header("HTTP/1.1 401 Unauthorized");
  exit;
}
if ($cart->isEmpty()) {
  echo json_encode($success);
  exit;
}

try {
  $stmt = $conn->prepare('INSERT INTO OrderInfo (orderDate, price, userId) VALUES (NOW(), ?, ?)');
  $stmt->bind_param('di', $cart->getTotalPrice(), $_SESSION['id']);
  $stmt->execute();
  
  $orderId = $conn->insert_id;
  $stmt->close();
  
  foreach ($cart->getProducts() as $product) {
    $stmt = $conn->prepare('INSERT INTO OrderedItem (orderId, productId) VALUES (?, ?)');
    $stmt->bind_param('ii', $orderId, $product->id);
    $stmt->execute();
    $stmt->close();
  }
  
  foreach ($cart->getTrips() as $trip) {
    $stmt = $conn->prepare(
      'INSERT INTO Trip (fromLat, fromLng, toLat, toLng, distance, carId, price, fulfillmentDate) ' .
      'VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('dddddids', $trip->fromLat, $trip->fromLng, $trip->toLat,
      $trip->toLng, $trip->distance, $trip->carId, $trip->price, $trip->fulfillmentDate);
    $stmt->execute();
    $tripId = $conn->insert_id;
    $stmt->close();
    $stmt = $conn->prepare('INSERT INTO OrderedItem (orderId, tripID) VALUES (?, ?)');
    $stmt->bind_param('ii', $orderId, $tripId);
    $stmt->execute();
    $stmt->close();
  }
  $conn->commit();
  $success['content'] = $orderId;
  echo json_encode($success);
  $_SESSION['cart'] = serialize(new Cart());
} catch (mysqli_sql_exception $e) {
  $conn->rollback();
  echo json_encode(constructError($e));
}

$conn->close();

?>
