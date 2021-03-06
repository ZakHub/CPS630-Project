<?php
$storename=$_POST['storename'];
$lat=$_POST['lat'];
$lng=$_POST['lng'];

include("connect.php");



$sql = "INSERT INTO store (storeName, lat, lng)
VALUES ('$storename', '$lat', '$lng')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
