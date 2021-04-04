<?php

session_start();
include_once('connect.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
  $review = file_get_contents('php://input');
  $stmt = $conn->prepare('INSERT INTO Review (feedback, userId) VALUE (?, ?)');
  $stmt->bind_param('si', $review, $_SESSION['id']);
  $stmt->execute();
  $stmt->close();
  respond(200, json_encode(array('status' => 'Success')));
} catch (mysqli_sql_exception $e) {
  respond(500, constructError($e));
}

$conn->close();

?>
