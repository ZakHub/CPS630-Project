<?php
// This file validates the information and adds it into the database.
require("connect.php");

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['eamil'];
$address = $_POST['address'];
$password1 = $_POST['password'];
$password2 = $_POST['password-repeat'];




$insertsql = "INSERT INTO UserInfo(firstName, lastName,phoneNumber,email,address,password) VALUES ('$firstName', '$lastName','phoneNumber''email''address''password')";

$selectsql = "SELECT firstName, password FROM UserInfo WHERE firstName='$firstName'";
$result = $conn->query($selectsql);

//username already exists in our table, redirecting to retry page
if ($result->num_rows > 0){
    header("Location: /Signup.html");
}

//username created, redirecting to login page 
else if ($conn->query($insertsql) === TRUE) {
    header("Location:/login.html");
}

else{
    echo mysqli_error($conn);
}

?>
