<?php

require_once('connect.php');

$racer = array('status' => 'Success', 'results' => array());
$racerQuery = 'SELECT * FROM Racer';
$luxuryCarQuery = 'SELECT * FROM LuxuryCar WHERE id = ?';

try {
	$result = $conn->query($racerQuery);
	while (($row = $result->fetch_assoc())) {
		array_push($racer['results'], $row);
	}
	$result->close();
	
	$stmt = $conn->prepare($LuxuryCarQuery);
	foreach ($racer['results'] as &$racer) {
		$racer['racers'] = array();
		$stmt->bind_param('i', $racer['id']);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			array_push($racer['racers'], $row);
		}
		$result->close();
	}
	$stmt->close();
	respond(200, json_encode($racer));
} catch (mysqli_sql_exception $e) {
	respond(500, constructError($e));
}

$conn->close();

?>
