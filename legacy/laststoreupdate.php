<?php
$id = $_POST["id"];
$storeName = $_POST["storeName"];
$lat = $_POST["lat"];
$lng = $_POST["lng"];
include("connect.php");

$sql = "update store set storename='{$storeName}',lat='{$lat}',lng='{$lng}' where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}