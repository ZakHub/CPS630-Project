<?php
/* Connects to MySQL Database */

function constructError($e) {
    return json_encode(array('status' => 'Failed', 'error' => '"' . $e . '"'));
}

// Login Credentials
$servername = "localhost";
//$username = "root";
$username = "project";
$password = "";
//$dbname = "P2S";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(constructError("Connection failed: " . $conn->connect_error));
}

?>
