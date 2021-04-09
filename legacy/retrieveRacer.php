<?php

require_once('connect.php');

$racer = array('status' => 'Success', 'results' => array());
$query = 'SELECT * FROM Racer';

if (($result = $conn->query($query))) {
	while (($row = $result->fetch_assoc())) {
		array_push($racer['results'], $row);
	}
	$result->close();
	respond(200, json_encode($racer));
} else {
	respond(500, constructError('Failed to execute query: ' . $conn->error));
}

$conn->close();

?>