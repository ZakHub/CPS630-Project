<?php
$Description=$_POST['Description'];
$StoreId=$_POST['StoreId'];


include("connect.php");



$sql = "INSERT INTO product(descrioption,storeId)
VALUES ('$Description', '$StoreId')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

