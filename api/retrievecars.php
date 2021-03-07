<?php

/* retrieve available cars on date provided by get argument "date" */
/* used by ServiceA.php */

include('../connect.php');

$cars = array('status' => 'Success', 'results' => array());
$query = 'SELECT * FROM Car';
if (isset($_GET['date'])) {
	$query = $query .
	' AS c
	WHERE c.id NOT IN (
		SELECT carId
		FROM Trip AS t
		INNER JOIN OrderedItem AS oi
		ON t.id = oi.tripId
		INNER JOIN OrderInfo as o
		ON oi.orderId = o.id
		WHERE o.fulfillmentDate = ?
	)';
}

$stmt = $conn->prepare($query);
if (!$stmt) {
	die(constructError('Failed to create prepared statment: ' . $conn->error));
}
if (isset($_GET['date'])) {
	if (!$stmt->bind_param('s', $_GET['date'])) {
		die(constructError('Failed to bind date parameter: ' . $stmt->error));
	}
}

if (!$stmt->execute()) {
	die(constructError('Failed to execute query: ' . $stmt->error));
}
/*if (!$stmt->bind_result($id, $model, $rate)) {
	die(constructError('Failed to bind results: ' . $stmt->error));
}
while (($row = $stmt->fetch())) {
	$row = array( 'id' => $id, 'model' => $model, 'rate' => $rate );
	array_push($cars['results'], $row);
}*/
$result = $stmt->get_result();
if (!$result) {
	die(constructError('Failed to get results of query: ' . $stmt->error));
}
while ($row = $result->fetch_assoc()) {
	array_push($cars['results'], $row);
}
$stmt->close();
$conn->close();

echo json_encode($cars);

?>
