<?php

require_once('connect.php');

$query = 'INSERT INTO Review (feedback, userId) VALUE (?, ?)';

try {
    $review = json_decode(file_get_contents('php://input'));
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $review->content, $review->userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    respond(200, json_encode(array('status' => 'Success')));
} catch (mysqli_sql_exception $e) {
    respond(500, constructError($e));
}


?>
