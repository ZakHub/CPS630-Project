<?php
$Description=$_POST['Description'];
$StoreId=$_POST['StoreId'];
$price =$_POST['price'];


include("connect.php");



$sql = "INSERT INTO product(description,storeId,price)
VALUES ('$Description', '$StoreId','$price')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

