<?php

require_once('connect.php');

$credentials = json_decode(file_get_contents('php://input'));

$response = array('status' => 'Success', 'results' => null);
$query = 'SELECT id, username FROM UserInfo WHERE username = ? AND passwrd = SHA1(?)';

$stmt = $conn->prepare($query);
if (!$stmt) {
	respond(500, constructError('Failed to create prepared statement: ' . $conn->error));
}
$stmt->bind_param('ss', $credentials->username, $credentials->password);
if (!$stmt->execute()) {
	respond(500, constructError('Failed to execute query: ' . $stmt->error));
}
$result = $stmt->get_result();
if (!$result) {
	respond(500, constructError('Failed to get results of query: ' . $stmt->error));
}

$response['results'] = $result->fetch_assoc();

respond(200, json_encode($response));

$result->close();
$stmt->close();
$conn->close();

?>
