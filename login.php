<?php
session_start();
require("connect.php");
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password1 = md5($password);
    $sql = "SELECT id,Username, passwrd  FROM UserInfo WHERE Username='$username' AND passwrd ='$password1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0){
        // set session variables & redirect to homepage
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['id'];
        header("Location:CPS630ProjectMain.php");
    }

    //login failed, redirecting to retry page
    else{
        header("Location:login.html");
    }
}

