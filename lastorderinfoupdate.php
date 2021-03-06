<?php
$id = $_POST["id"];
$orderDate = $_POST["orderDate"];
$fulfillmentDate = $_POST["fulfillmentDate"];
$price = $_POST["price"];
$userId = $_POST["userId"];
include("connect.php");

$sql = "update OrderInfo set orderDate='{$orderDate}',fulfillmentDate='{$fulfillmentDate}',price='{$price}',userId='{$userId}' where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}