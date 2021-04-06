<?php

require_once('connect.php');

$user = json_decode(file_get_contents('php://input'));

$query =
	'INSERT INTO UserInfo ' .
	'(username, firstName, lastName, phoneNumber, email, address, passwrd) ' .
	'VALUES (?, ?, ?, ?, ?, ?, SHA1(?))';

try {
	$stmt = $conn->prepare($query);
	$stmt->bind_param('sssssss', $user->username, $user->firstname,
		$user->lastname, $user->phone, $user->email, $user->address,
		$user->password);
	$stmt->execute();
	respond(200, json_encode(array('status' => 'Success')));
	$stmt->close();
} catch (mysqli_sql_exception $e) {
	respond(500, constructError($e));
}

$conn->close();

?>
