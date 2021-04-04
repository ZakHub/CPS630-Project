<?php

require_once('connect.php');

$user = json_decode(file_get_contents('php://input'));

$query =
'INSERT INTO UserInfo ' .
'(username, firstName, lastName, phoneNumber, email, address, passwrd) ' .
'VALUES (?, ?, ?, ?, ?, ?, SHA1(?))';

$stmt = $conn->prepare($query);
if (!$stmt) {
	respond(500, construct_error('Failed to prepare statement: ' . $conn->error));
}
if (!$stmt->bind_param('sssssss', $user->username, $user->firstname,
	$user->lastname, $user->phone, $user->email, $user->address,
	$user->password)) {
	respond(500, 'Failed to bind arguments: ' . $stmt->error);
}

if (!$stmt->execute()) {
	respond(500, 'Failed to add user: ' . $stmt->error);
}

respond(200, json_encode(array('status' => 'Success')));


$stmt->close();
$conn->close();

?>
