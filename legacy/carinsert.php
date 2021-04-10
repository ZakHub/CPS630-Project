<?php
$Model=$_POST['Model'];
$Rate=$_POST['Rate'];


include("connect.php");



$sql = "INSERT INTO car(model,rate)
VALUES ('$Model', '$Rate')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
