<?php
$id=$_GET['id'];
include("connect.php");

// sql to delete a record
$sql = "DELETE FROM userInfo WHERE id={$id}";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
