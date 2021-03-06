<?php
$id = $_POST["id"];
$fromLat = $_POST["fromLat"];
$fromLng = $_POST["fromLng"];
$toLat = $_POST["toLat"];
$toLng = $_POST["toLng"];
$distance = $_POST["distance"];
$carId = $_POST["carId"];
$price = $_POST["price"];
include("connect.php");

$sql = "update trip set fromLat='{$fromLat}',fromLng='{$fromLng}',toLat='{$toLat}',toLat='{$toLat}',distance='{$distance}',carId='{$carId}',price='{$price}' where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}
