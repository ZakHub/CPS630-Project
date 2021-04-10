<?php
$id = $_POST["id"];
$username = $_POST["username"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$phoneNumber = $_POST["phoneNumber"];
$email = $_POST["email"];
$address = $_POST["address"];
$balance = $_POST["balance"];

include("connect.php");

$sql = "update UserInfo set username='{$username}',firstName='{$firstName}',lastName='{$lastName}',phoneNumber='{$phoneNumber}',email='{$email}',address='{$address}',balance='{$balance}' where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}
