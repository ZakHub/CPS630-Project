<?php

require_once('connect.php');

$stores = array('status' => 'Success', 'results' => array());
$query = 'SELECT * FROM Store';

if (($result = $conn->query($query))) {
	while (($row = $result->fetch_assoc())) {
		array_push($stores['results'], $row);
	}
	$result->close();
	respond(200, json_encode($stores));
} else {
	respond(500, constructError('Failed to execute query: ' . $conn->error));
}

$conn->close();

?>
