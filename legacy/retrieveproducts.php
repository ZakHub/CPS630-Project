<?php

require_once('connect.php');

$products = array('status' => 'Success', 'results' => array());
$query = 'SELECT * FROM Product';
if (isset($_GET['storeId'])) {
	$query = $query . ' WHERE StoreId = ?';
}
$stmt = $conn->prepare($query);
if (!$stmt) {
	respond(500, constructError('Failed to create prepared statement: ' . $conn->error));
}
if (isset($_GET['storeId'])) {
	if (!$stmt->bind_param('d', $_GET['storeId'])) {
		respond(500, constructError('Failed to bind store ID parameter: ' .
			$stmt->error));
	}
}

if (!$stmt->execute()) {
	respond(500, constructError('Failed to execute SQL query: ' . $stmt->error));
}
$result = $stmt->get_result();
if (!$result) {
	respond(500, constructError('Failed to retrieve result set: ' . $stmt->error));
}
while ($row = $result->fetch_assoc()) {
	array_push($products['results'], $row);
}

respond(200, json_encode($products));

$result->close();
$stmt->close();
$conn->close();

?>