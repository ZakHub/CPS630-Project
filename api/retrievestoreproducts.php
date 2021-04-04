<?php

require_once('connect.php');

$stores = array('status' => 'Success', 'results' => array());
$query = 'SELECT * FROM Store';

if (($result = $conn->query($query))) {
	while (($row = $result->fetch_assoc())) {
		array_push($stores['results'], $row);
	}
	$result->close();
	//respond(200, json_encode($stores));
} else {
	respond(500, constructError('Failed to execute query: ' . $conn->error));
}

$query = 'SELECT * FROM Product WHERE StoreId = ?';
$stmt = $conn->prepare($query);
if (!stmt) {
	respond(500, constructError('Failed to prepare statement: ' . $conn->error));
}
foreach ($stores['results'] as &$store) {
	$store['products'] = array();
	$stmt->bind_param('i', $store['id']);
	if (!$stmt->execute()) {
		respond(500, constructError('Failed to execute statement: ' . $stmt->error));
	}
	$result = $stmt->get_result();
	if (!$result) {
		respond(500, constructError('Failed to get results: ' . $stmt->error));
	}
	while ($row = $result->fetch_assoc()) {
		array_push($store['products'], $row);
	}
	$result->close();
}

respond(200, json_encode($stores));

$stmt->close();
$conn->close();

?>
