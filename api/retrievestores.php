<?php

include('../connect.php');

$stores = array('status' => 'Success', 'results' => array());
$query = 'SELECT * FROM Store';

if (($result = $conn->query($query))) {
	while (($row = $result->fetch_assoc())) {
		array_push($stores['results'], $row);
	}
	$result->close();
	echo json_encode($stores);
} else {
	die(constructError('Failed to execute query: ' . $conn->error));
}

$conn->close();

?>
