<?php
// This file validates the information and adds it into the database.
require("connect.php");
$username = $_POST['username'];
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$phoneNumber = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];

$password = $_POST['password'];
$password1 =md5($password);
$password2 = $_POST['password-repeat'];




$insertsql = "INSERT INTO UserInfo(username,firstName, lastName,phoneNumber,email,address,passwrd) VALUES ('$username','$firstName', '$lastName','$phoneNumber','$email','$$address','$password1')";

$selectsql = "SELECT username, passwrd  FROM UserInfo WHERE username='$username'";
$result = $conn->query($selectsql);

//username already exists in our table, redirecting to retry page
if ($result->num_rows > 0){
    header("Location:Signup.html");
}

//username created, redirecting to login page 
else if ($conn->query($insertsql) === TRUE) {
    header("Location:login.html");
}

else{
    echo mysqli_error($conn);
}

?>
