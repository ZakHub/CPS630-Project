<?php

require_once('connect.php');

$query =
    'SELECT LEFT(ui.firstName, 1) AS firstInitial, ' .
    'LEFT(ui.lastName, 1) AS lastInitial, r.feedback ' .
    'FROM Review AS r ' .
    'INNER JOIN UserInfo AS ui ' .
    'ON ui.id = r.userId';

$reviews = array('status' => 'Success', 'results' => array());
if ($result = $conn->query($query)) {
    while ($review = $result->fetch_assoc()) {
	array_push($reviews['results'], $review);
    }

    respond(200, json_encode($reviews));

    $result->close();
} else {
    respond(500, constructError($conn->error));
}

$conn->close();

?>
