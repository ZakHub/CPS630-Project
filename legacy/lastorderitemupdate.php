<?php
$id = $_POST["id"];
$orderId = $_POST["orderId"];
$tripId = $_POST["tripId"];
$productId = $_POST["productId"];
include("connect.php");

$sql = "update OrderedItem set orderId='{$orderId}',tripId='{$tripId}',productId='{$productId}' where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}
