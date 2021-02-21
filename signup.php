<?php
// This file validates the information and adds it into the database.
require("connect.php");

$username = $_POST['username'];
$password1 = $_POST['password'];
$password2 = $_POST['password-repeat'];

$insertsql = "INSERT INTO Users(Username, Password) VALUES ('$username', '$password1')";

$selectsql = "SELECT Username, Password FROM Users WHERE Username='$username'";
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
